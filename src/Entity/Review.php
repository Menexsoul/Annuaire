<?php

namespace App\Entity;

use App\Repository\ReviewRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column(length: 255)]
    private ?string $comment = null;

    #[ORM\Column]
    private ?\DateTime $CreatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'UnAvis')]
    private ?User $UnUtilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'DesAvis')]
    private ?Player $UnJoueur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(string $comment): static
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTime $CreatedAt): static
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUnUtilisateur(): ?User
    {
        return $this->UnUtilisateur;
    }

    public function setUnUtilisateur(?User $UnUtilisateur): static
    {
        $this->UnUtilisateur = $UnUtilisateur;

        return $this;
    }

    public function getUnJoueur(): ?Player
    {
        return $this->UnJoueur;
    }

    public function setUnJoueur(?Player $UnJoueur): static
    {
        $this->UnJoueur = $UnJoueur;

        return $this;
    }
}
