<?php

namespace App\Application\Security\Voter;

use App\Domain\Entity\Retailer;
use App\Domain\Repository\RetailerRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class RetailerVoter
 * @author ereshkidal
 */
class RetailerVoter extends Voter
{
    private const VIEW = 'view';
    private const EDIT = 'edit';
    private const DELETE = 'delete';

    /**
     * @var RetailerRepository
     */
    private $retailerRepository;

    /**
     * RetailerVoter constructor.
     * @param RetailerRepository $retailerRepository
     */
    public function __construct(RetailerRepository $retailerRepository)
    {
        $this->retailerRepository = $retailerRepository;
    }

    /**
     * Determines if the attribute and subject are supported by this voter.
     *
     * @param string $attribute An attribute
     * @param mixed $subject The subject to secure, e.g. an object the user wants to access or any other PHP type
     *
     * @return bool True if the attribute and subject are supported, false otherwise
     */
    protected function supports($attribute, $subject): ?bool
    {
        if (!in_array($attribute, [self::VIEW, self::EDIT, self::DELETE], true)) {
            return false;
        }

        return true;
    }

    /**
     * Perform a single access check operation on a given attribute, subject and token.
     * It is safe to assume that $attribute and $subject already passed the "supports()" method check.
     *
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     *
     * @return bool
     */
    protected function voteOnAttribute($attribute, $subject, TokenInterface $token): bool
    {
        $retailer = $this->retailerRepository->find($subject);
        $currentUser = $token->getUser();

        if (!$currentUser instanceof Retailer || !$retailer instanceof Retailer) {
            return false;
        }

        switch ($attribute) {
            case self::VIEW:
                return $this->canView($retailer, $currentUser);
            case self::EDIT:
                return $this->canEdit($retailer, $currentUser);
            case self::DELETE:
                return $this->canDelete($retailer, $currentUser);
        }

        throw new \LogicException('This code should not be reached!');
    }

    /**
     * @param Retailer $retailer
     * @param Retailer $currentUser
     * @return bool
     */
    private function canView(Retailer $retailer, Retailer $currentUser): bool
    {
        if ($this->canEdit($retailer, $currentUser)) {
            return true;
        }

        return false;
    }

    /**
     * @param Retailer $retailer
     * @param Retailer $currentUser
     * @return bool
     */
    private function canEdit(Retailer $retailer, Retailer $currentUser): bool
    {
        return ($currentUser->getEmail() === $retailer->getEmail());
    }

    /**
     * @param Retailer $retailer
     * @param Retailer $currentUser
     * @return bool
     */
    private function canDelete(Retailer $retailer, Retailer $currentUser): bool
    {
        return ($currentUser->getEmail() === $retailer->getEmail());
    }
}
