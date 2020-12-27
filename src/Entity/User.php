<?php

declare(strict_types=1);

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 */
class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="bigint")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(type="string")
     */
    private $clientId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @var int
     *
     * @ORM\Column(type="string")
     */
    private $username;

    /**
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $lastLogin;

    /**
     * @var array
     *
     * @ORM\Column(type="json_array")
     */
    private $roles = [];

    /**
     * @var Comment[]
     *
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="user")
     */
    private $comments;

    /**
     * @param $clientId
     * @param string $email
     * @param string $username
     * @param array $roles
     */
    public function __construct(
        $clientId,
        string $email,
        string $username,
        array $roles = [self::ROLE_USER]
    ) {
        $this->clientId = $clientId;
        $this->email = $email;
        $this->username = $username;
        $this->lastLogin = new DateTime('now');
        $this->roles = $roles;
        $this->comments = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return DateTimeInterface
     */
    public function getLastLogin(): DateTimeInterface
    {
        return $this->lastLogin;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    public function username()
    {
        return $this->username;
    }

    public function eraseCredentials(): void
    {
    }

    public function getPassword()
    {
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}