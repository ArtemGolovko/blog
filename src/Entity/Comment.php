<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=false)
     */
    private $comment;

    /**
     * @var Post
     *
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="comments")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $post;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="comments")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private $user;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     */
    private $createdAt;

    /**
     * @var DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     */
    private $updatedAt;

    private function __construct()
    {
        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = new DateTimeImmutable();
    }

    /**
     * @param string $content
     * @param User $user
     * @param Post $post
     * @return Comment
     */
    public static function create(string $content, User $user, Post $post): Comment
    {
        $comment = new self();
        $comment->comment = $content;
        $comment->user = $user;
        $comment->post = $post;

        return $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return Post
     */
    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}
