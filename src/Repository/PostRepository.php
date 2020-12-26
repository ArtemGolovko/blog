<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Post;

class PostRepository
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var EntityRepository
     */
    private $repository;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->repository = $em->getRepository(Post::class);
    }

    public function add(Post $post)
    {
        $this->em->persist($post);
    }

    public function findOneBySlug(string $slug)
    {
        return $this->repository->findOneBy(['slug' => $slug]);
    }

    public function findAll()
    {
        return $this->repository->findAll();
    }
}