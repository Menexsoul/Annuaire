<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $BirthDate = null;

    #[ORM\ManyToOne(inversedBy: 'UnJoueur')]
    private ?Category $MaCategorie = null;

    #[ORM\ManyToOne(inversedBy: 'DesJoueurs')]
    private ?Niveau $UnNiveau = null;

    /**
     * @var Collection<int, Review>
     */
    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'UnJoueur')]
    private Collection $DesAvis;

    public function __construct()
    {
        $this->DesAvis = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): static
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getBirthDate(): ?\DateTime
    {
        return $this->BirthDate;
    }

    public function setBirthDate(\DateTime $BirthDate): static
    {
        $this->BirthDate = $BirthDate;

        return $this;
    }

    public function getMaCategorie(): ?Category
    {
        return $this->MaCategorie;
    }

    public function setMaCategorie(?Category $MaCategorie): static
    {
        $this->MaCategorie = $MaCategorie;

        return $this;
    }

    public function getUnNiveau(): ?Niveau
    {
        return $this->UnNiveau;
    }

    public function setUnNiveau(?Niveau $UnNiveau): static
    {
        $this->UnNiveau = $UnNiveau;

        return $this;
    }

    /**
     * @return Collection<int, Review>
     */
    public function getDesAvis(): Collection
    {
        return $this->DesAvis;
    }

    public function addDesAvi(Review $desAvi): static
    {
        if (!$this->DesAvis->contains($desAvi)) {
            $this->DesAvis->add($desAvi);
            $desAvi->setUnJoueur($this);
        }

        return $this;
    }

    public function removeDesAvi(Review $desAvi): static
    {
        if ($this->DesAvis->removeElement($desAvi)) {
            // set the owning side to null (unless already changed)
            if ($desAvi->getUnJoueur() === $this) {
                $desAvi->setUnJoueur(null);
            }
        }

        return $this;
    }
}
