<?php

namespace App\Entity;

use App\Repository\NiveauRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NiveauRepository::class)]
class Niveau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    /**
     * @var Collection<int, Player>
     */
    #[ORM\OneToMany(targetEntity: Player::class, mappedBy: 'UnNiveau')]
    private Collection $DesJoueurs;

    public function __construct()
    {
        $this->DesJoueurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getDesJoueurs(): Collection
    {
        return $this->DesJoueurs;
    }

    public function addDesJoueur(Player $desJoueur): static
    {
        if (!$this->DesJoueurs->contains($desJoueur)) {
            $this->DesJoueurs->add($desJoueur);
            $desJoueur->setUnNiveau($this);
        }

        return $this;
    }

    public function removeDesJoueur(Player $desJoueur): static
    {
        if ($this->DesJoueurs->removeElement($desJoueur)) {
            // set the owning side to null (unless already changed)
            if ($desJoueur->getUnNiveau() === $this) {
                $desJoueur->setUnNiveau(null);
            }
        }

        return $this;
    }
}
