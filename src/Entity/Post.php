<?php

declare(strict_types=1);

namespace App\Entity;

use App\Entity\Comment;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="posts", indexes={
 *     @ORM\Index(columns={"user_id"}),
 *     @ORM\Index(columns={"status"}),
 *     @ORM\Index(columns={"created_at"})
 * })
 * @ORM\HasLifecycleCallbacks
 */
class Post
{
    use CreatedAtTrait, UpdatedAtTrait;

    public const DRAFT = 'draft';
    public const PUBLISHED = 'published';

    /**
     * @var Uuid
     * @ORM\Id()
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
    private $status;


    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $publishedAt;


    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="SET NULL", nullable=true)
     */
    private $user;

    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", cascade={"persist"})
     * @ORM\JoinTable(name="post_categories")
     * @ORM\JoinColumn(referencedColumnName="id", nullable=false)
     */
    private $categories;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="post")
     */
    private $comments;



    private function __construct()
    {
        $this->id = Uuid::uuid4();
        $this->categories = new ArrayCollection();
    }

    public static function fromDraft(
        User $user,
        ?string $title = null,
        ?string $body = null,
        ?string $slug = null
    ): Post {

        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->user = $user;
        $post->status = self::DRAFT;

        return $post;
    }

    public static function fromPublished(string $title, string $body, string $slug): Post
    {
        $post = new self();
        $post->title = $title;
        $post->body = $body;
        $post->slug = $slug;
        $post->publishedAt = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
        $post->status = self::PUBLISHED;

        return $post;
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
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug): void
    {
        $this->slug = $slug;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body): void
    {
        $this->body = $body;
    }
}