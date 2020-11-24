<?php

namespace App\Security\Voter;

use LogicException;
use App\Entity\Player;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class PlayerVoter extends Voter
{
    public const PLAYER_DISPLAY = 'playerDisplay';
    public const PLAYER_CREATE = 'playerCreate';
    public const PLAYER_INDEX = 'playerIndex';
    public const PLAYER_MODIFY = 'playerModify';
    public const PLAYER_DELETE = 'playerDelete';


    private const ATTRIBUTES = array(
        self::PLAYER_DISPLAY,
        self::PLAYER_CREATE,
        self::PLAYER_INDEX,
        self::PLAYER_MODIFY,
        self::PLAYER_DELETE,
    );

    /**
     * Est ce que je supporte l'attribut qui est demandé, ici l'attribut est playerDisplay
     */

    protected function supports($attribute, $subject)
    {
        if (null !== $subject) {
            return $subject instanceof Player && in_array($attribute, self::ATTRIBUTES);
        }
        return in_array($attribute, self::ATTRIBUTES);
    }

    /**
     * Si l'attribut est supporté, est qu'on a les droit la dessus ?
     */

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        switch ($attribute) {
            case self::PLAYER_DISPLAY:
            case self::PLAYER_INDEX:
                // peut envoyer $token et $subject pour tester des conditions
                return $this->canDisplay();
                break;
            case self::PLAYER_CREATE:
                // peut envoyer $token et $subject pour tester des conditions
                return $this->canCreate();
                break;
            case self::PLAYER_MODIFY:
                // peut envoyer $token et $subject pour tester des conditions
                return $this->canModify();
                break;
            case self::PLAYER_DELETE:
                // peut envoyer $token et $subject pour tester des conditions
                return $this->canDelete();
                break;
        }

        throw new LogicException('Invalid attribute: ' . $attribute);
    }

    /**
     * Check if is allowed to display
     */

    public function canDisplay()
    {
        return true;
    }

    /**
     * Check if is allowed to create
     */

    public function canCreate()
    {
        return true;
    }

    /**
     * Check if is allowed to modify
     */

    public function canModify()
    {
        return true;
    }

    /**
     * Check if is allowed to delete
     */

    public function canDelete()
    {
        return true;
    }
}
