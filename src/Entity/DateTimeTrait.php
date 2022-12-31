<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

trait DateTimeTrait
{
    /** @ORM\Column(name="created_at", type="datetime") */
    private DateTimeInterface $createdAt;

    /** @ORM\Column(name="updated_at", type="datetime") */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist(): void
    {
        $this->setCreatedAt(new DateTime());
        $this->setUpdatedAt(new DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(): void
    {
        $this->setUpdatedAt(new DateTime());
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
