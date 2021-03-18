<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Entity\Profile;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProfileVoter extends Voter
{
    const CREATE = 'create';
    const LIST = 'list';
    const SHOW = 'show';
    const EDIT = 'edit';
    const DELETE = 'delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports($attribute, $subject)
    {
        
        if (!in_array($attribute, [self::CREATE, self::LIST, self::SHOW, self::DELETE, self::EDIT])) {
            return false;
        }

        if (!$subject instanceof Profile) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        
        $loggedUser = $token->getUser();
        
        if (!$loggedUser instanceof User) {
            return false;
        }

        if (!$loggedUser->getIsActive()) {
            return false;
        }

        switch ($attribute) {
            case self::LIST:
                return $this->canAccessAll();
            case self::CREATE:
                return $this->canCreate();
            case self::EDIT:
                return $this->canEdit();
            case self::SHOW:
                return $this->canAccess();
            case self::DELETE:
                return $this->canDelete();
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canCreate()
    {
        if($this->security->isGranted('ROLE_PROFILE_NEW'))
        {
            return true;
        }
    }

    private function canEdit()
    {
        if($this->security->isGranted('ROLE_PROFILE_EDIT'))
        {
            return true;
        }
    }

    private function canAccessAll()
    {
        if($this->security->isGranted('ROLE_PROFILE'))
        {
            return true;
        }
    }

    private function canAccess()
    {
        if($this->security->isGranted('ROLE_PROFILE_SHOW'))
        {
            return true;
        }
    }

    private function canDelete()
    {
        if($this->security->isGranted('ROLE_PROFILE_DELETE'))
        {
            return true;
        }

        return false;
    }
}