<?php

declare(strict_types=1);

namespace App\Application\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManager;

class UserManager
{
    private $em;
    private $userRepository;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
    }

    public function grand(string $email, array $roles)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        $userRoles = $user->getRoles();
        $user->setRoles(
            array_unique(
                array_merge(
                    $userRoles,
                    $roles
                )
            )
        );
        $this->em->flush();
    }

    public function ungrand(string $email, array $roles)
    {
        $user = $this->userRepository->findOneBy(['email' => $email]);
        $userRoles = $user->getRoles();
        $user->setRoles(
            array_unique(
                array_merge(
                    array_diff(
                        $userRoles,
                        $roles
                    ),
                    [User::ROLE_USER]
                )
            )
        );
        $this->em->flush();
    }
}