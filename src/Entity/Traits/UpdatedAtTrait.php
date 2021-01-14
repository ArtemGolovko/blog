<?php


namespace App\Entity\Traits;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\HasLifecycleCallbacks
 */
trait UpdatedAtTrait
{
    /**
     * @var \DateTimeImmutable
     *
     * @ORM\Column(type="date_immutable")
     */
    private $updatedAt;

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateUpdatedAt()
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getUpdatedAt(): \DateTimeImmutable
    {
        return $this->updatedAt;
    }
}