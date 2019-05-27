<?php

namespace App\Application\Security\Voter;

use App\Domain\Entity\Retailer;
use App\Domain\Model\RetailerModel;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class RetailerVoter
 * @author ereshkidal
 */
class RetailerVoter extends Voter
{
    private const VIEW = 'view';

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
        if ($attribute !== self::VIEW) {
            return false;
        }

        if (!$subject instanceof RetailerModel) {
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
        if (!$subject instanceof RetailerModel) {
            return false;
        }
        /** @var Retailer $retailer */
        $retailer = $token->getUser();

        return ($retailer->getEmail() === $subject->email);
    }
}
