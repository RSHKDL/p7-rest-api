<?php

namespace App\Application\Validation\Constraints;

use App\Domain\Entity\Retailer;
use App\Domain\Repository\ClientRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\TokenNotFoundException;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Class NoDuplicateClientEmailValidator
 * @author ereshkidal
 */
final class NoDuplicateClientEmailValidator extends ConstraintValidator
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * NoDuplicateClientEmailValidator constructor.
     * @param ClientRepository $clientRepository
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(
        ClientRepository $clientRepository,
        TokenStorageInterface $tokenStorage
    ) {
        $this->clientRepository = $clientRepository;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Check if a Client already exist with a given email for a given Retailer
     *
     * @param mixed $value The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof NoDuplicateClientEmail) {
            throw new UnexpectedTypeException($constraint, NoDuplicateClientEmail::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        $token = $this->tokenStorage->getToken();
        if (!$token) {
            throw new TokenNotFoundException('No token found.');
        }

        /** @var Retailer $retailer */
        $retailer = $token->getUser();
        $client = $this->clientRepository->findOneByEmailAndRetailerUuid($value, $retailer->getId());

        if ($client) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
