<?php

namespace App\Security\Voter;

use App\Entity\MarquePage;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class MarquePageVoter extends Voter
{
    const MARQUE_PAGE_EDIT = 'MARQUE_PAGE_EDIT';
    const MARQUE_PAGE_DELETE = 'MARQUE_PAGE_DELETE';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::MARQUE_PAGE_EDIT, self::MARQUE_PAGE_DELETE])
        && $subject instanceof \App\Entity\MarquePage;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        $mp = $subject;
        switch ($attribute) {
            case self::MARQUE_PAGE_EDIT:
                return $this->canEdit($mp, $user);

            case self::MARQUE_PAGE_DELETE:
                return $this->canDelete($mp, $user);
        }

        return false;
    }

    private function canEdit(MarquePage $mp, User $user)
    {
        return $user === $mp->getUser();
    }

    private function canDelete(MarquePage $mp, User $user)
    {
        return $user === $mp->getUser();
    }
}
