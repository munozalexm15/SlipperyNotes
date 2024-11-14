<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    /**
     * @var Collection<int, Notes>
     */
    #[ORM\ManyToMany(targetEntity: Notes::class, mappedBy: 'idCategory')]
    private Collection $idNote;

    public function __construct()
    {
        $this->idNote = new ArrayCollection();
    }

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

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Notes>
     */
    public function getIdNote(): Collection
    {
        return $this->idNote;
    }

    public function addIdNote(Notes $idNote): static
    {
        if (!$this->idNote->contains($idNote)) {
            $this->idNote->add($idNote);
            $idNote->addIdCategory($this);
        }

        return $this;
    }

    public function removeIdNote(Notes $idNote): static
    {
        if ($this->idNote->removeElement($idNote)) {
            $idNote->removeIdCategory($this);
        }

        return $this;
    }
}
