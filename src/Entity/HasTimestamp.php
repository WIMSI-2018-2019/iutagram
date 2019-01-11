<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait HasTimestamp
{
    /**
     * @Groups({"timestamps", "created_at"})
     * @ORM\Column(type="datetime_immutable");
     *
     * @var \DateTimeInterface
     */
    private $createdAt;

    /**
     * @Groups({"timestamps", "updated_at"})
     * @ORM\Column(type="datetime_immutable");
     *
     * @var \DateTimeInterface
     */
    private $updatedAt;

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist()
     *
     * @throws \Exception
     */
    public function prePersistTimestamp()
    {
        $this->createdAt = new \DateTimeImmutable;
        $this->updatedAt = new \DateTimeImmutable;
    }

    /**
     * @ORM\PreUpdate()
     *
     * @throws \Exception
     */
    public function preUpdateTimestamp()
    {
        $this->updatedAt = new \DateTimeImmutable;
    }
}
