<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity()
 * @ORM\Table(name="categories", indexes={
 *     @ORM\Index(columns={"name"}),
 *     @ORM\Index(columns={"date"})
 *  })
 */
class Category
{
    /**
     * @var Uuid
     * @ORM\Id()
     * @ORM\Column(type="uuid")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    public function __construct(string $name)
    {
        $this->id = Uuid::uuid4();
        $this->name = $name;
        $this->date = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow'));
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}