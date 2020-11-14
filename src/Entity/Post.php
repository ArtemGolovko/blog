<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="posts", indexes={
 *     @ORM\Index(columns={"user_id"}),
 *     @ORM\Index(columns={"status"}),
 *     @ORM\Index(columns={"created_at"})
 * })
 */
class Post
{
    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';

    /**
     * @ORM\Id
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $body;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    public $status;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private $createdAt;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=false)
     */
    private $updatedAt;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $user;

    private function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPublishedAt(): \DateTimeImmutable
    {
        return $this->publishedAt;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public static function fromDraft(
        User $user,
        ?string $title,
        ?string $body,
        ?string $slug
    ): Post {

        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->user = $user;
        $post->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->status = self::DRAFT;

        return $post;
    }

    public static function fromPublished(string $title, string $body, string $slug): Post
    {
        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->updatedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->publishedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->status = self::PUBLISHED;

        return $post;
    }
}