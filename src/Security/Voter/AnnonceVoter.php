<?php

namespace App\Security\Voter;

use App\Entity\Annonce;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class AnnonceVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const DELETE = 'POST_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof \App\Entity\Annonce;
    }

    protected function voteOnAttribute(string $attribute, $annonce, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EDIT:
                if ($annonce->getTelephone() == $user->getTelephone()) {
                    return true;
                }
                break;
            case self::DELETE:
                if ($annonce->getTelephone() == $user->getTelephone()) {
                    return true;
                }
                break;
        }

        return false;
    }
}
