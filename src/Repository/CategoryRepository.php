<?php

declare(strict_types=1);

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use App\Entity\Category;

class CategoryRepository
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
        $this->repository = $em->getRepository(Category::class);
    }

    public function add(Category $category)
    {
        $this->em->persist($category);
    }

    public function findOneByName(string $name)
    {
        return $this->repository->findOneBy(['name' => $name]);
    }
}