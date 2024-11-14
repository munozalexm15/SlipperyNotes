<?php

namespace App\Entity;

use App\Repository\PhotosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PhotosRepository::class)]
class Photos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $resourcePath = null;

    #[ORM\OneToOne(mappedBy: 'idPhoto', cascade: ['persist', 'remove'])]
    private ?Notes $idNote = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getResourcePath(): ?string
    {
        return $this->resourcePath;
    }

    public function setResourcePath(string $resourcePath): static
    {
        $this->resourcePath = $resourcePath;

        return $this;
    }

    public function getIdNote(): ?Notes
    {
        return $this->idNote;
    }

    public function setIdNote(?Notes $idNote): static
    {
        // unset the owning side of the relation if necessary
        if ($idNote === null && $this->idNote !== null) {
            $this->idNote->setIdPhoto(null);
        }

        // set the owning side of the relation if necessary
        if ($idNote !== null && $idNote->getIdPhoto() !== $this) {
            $idNote->setIdPhoto($this);
        }

        $this->idNote = $idNote;

        return $this;
    }
}
