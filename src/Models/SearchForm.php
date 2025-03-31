<?php

namespace App\Models;

use App\Entity\Site;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\Validator\Constraints as Assert;

class SearchForm
{
    #[Assert\Type("App\Entity\Site")]
    private ?Site $site = null;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min:2, max:255)]
    #[Assert\Regex(
        pattern: "/<[^>]*>/",
        message: "Le nom ne doit pas contenir de balises HTML.",
        match: false
    )]
    private ?string $nom = null;

    #[Assert\LessThanOrEqual(propertyPath:"dateFin", message:"La date saisie ne peut pas être apres la date de fin.")]
    private ?\DateTimeInterface $dateDebut = null;

    #[Assert\GreaterThanOrEqual(propertyPath:"dateDebut", message:"La date saisie ne peut pas être avant la date de début.")]
    private ?\DateTimeInterface $dateFin = null;

    /**
     * @var bool|null
     * @Assert\Type(type="bool")
     */
    private ?bool $organisateur = null;

    private ?bool $inscrit = null;


    private ?bool $nonInscrit = null;


    private ?bool $sortiesPassees = null;

    // Getters and Setters

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): void
    {
        $this->site = $site;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): void
    {
        $this->nom = $nom;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(?\DateTimeInterface $dateDebut): void
    {
        $this->dateDebut = $dateDebut;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(?\DateTimeInterface $dateFin): void
    {
        $this->dateFin = $dateFin;
    }

    public function isOrganisateur(): ?bool
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?bool $organisateur): void
    {
        $this->organisateur = $organisateur;
    }

    public function isInscrit(): ?bool
    {
        return $this->inscrit;
    }

    public function setInscrit(?bool $inscrit): void
    {
        $this->inscrit = $inscrit;
    }

    public function isNonInscrit(): ?bool
    {
        return $this->nonInscrit;
    }

    public function setNonInscrit(?bool $nonInscrit): void
    {
        $this->nonInscrit = $nonInscrit;
    }

    public function isSortiesPassees(): ?bool
    {
        return $this->sortiesPassees;
    }

    public function setSortiesPassees(?bool $sortiesPassees): void
    {
        $this->sortiesPassees = $sortiesPassees;
    }
}

