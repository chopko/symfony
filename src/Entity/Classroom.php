<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations as SWG;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClassroomRepository")
 */
class Classroom
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="guid")
     * @Groups({"classroom", "classrooms"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"classroom", "classrooms"})
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"classroom", "classrooms"})
     * @SWG\Property(property="is_active")
     */
    private $isActive;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"classroom", "classrooms"})
     * @SWG\Property(property="created_at")
     */
    private $createdAt;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(?string $id)
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
