<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class RegisteredUserEvent extends Event
{
    public const NAME = 'user.register';

    /**
     * @var User
     */
    private $registeredUser;

    /**
     * RegisteredUserEvent constructor.
     * @param User $registeredUser
     */
    public function __construct(User $registeredUser)
    {
        $this->registeredUser = $registeredUser;
    }

    /**
     * @return User
     */
    public function getRegisteredUser(): User
    {
        return $this->registeredUser;
    }


}