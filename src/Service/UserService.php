<?php


namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    private $em;
    private $userRepository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->userRepository = $em->getRepository(User::class);
    }

    public function grand(array $criteria, array $roles): bool
    {
        $user = $this->userRepository->findOneBy($criteria);
        if (!$user) {
            return false;
        }
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
        return true;
    }

    public function ungrand(array $criteria, array $roles): bool
    {
        $user = $this->userRepository->findOneBy($criteria);
        if (!$user) {
            return false;
        }
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
        return true;
    }
}