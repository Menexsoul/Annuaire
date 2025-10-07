<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    /**
     * @var Collection<int, Player>
     */
    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'MaCategorie')]
    private Collection $UnJoueur;

    public function __construct()
    {
        $this->UnJoueur = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): static
    {
        $this->Nom = $Nom;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getUnJoueur(): Collection
    {
        return $this->UnJoueur;
    }

    public function addUnJoueur(Player $unJoueur): static
    {
        if (!$this->UnJoueur->contains($unJoueur)) {
            $this->UnJoueur->add($unJoueur);
            $unJoueur->setMaCategorie($this);
        }

        return $this;
    }

    public function removeUnJoueur(Player $unJoueur): static
    {
        if ($this->UnJoueur->removeElement($unJoueur)) {
            // set the owning side to null (unless already changed)
            if ($unJoueur->getMaCategorie() === $this) {
                $unJoueur->setMaCategorie(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->getNom();
    }
}
