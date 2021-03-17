<?php

namespace App\Entity;

use App\Repository\FiltreRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FiltreRepository::class)
 */
class Filtre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=15,nullable=true )
     */
    private $campus;

    /**
     * @ORM\Column(type="string", length=255,nullable=true )
     */
    private $Search;

    /**
     * @ORM\Column(type="date",nullable=true )
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date",nullable=true )
     */
    private $dateFin;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $orga;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inscrit;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pasInscrit;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $close;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCampus(): ?string
    {
        return $this->campus;
    }

    public function setCampus(?string $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getSearch(): ?string
    {
        return $this->Search;
    }

    public function setSearch(string $Search): self
    {
        $this->Search = $Search;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getOrga(): ?bool
    {
        return $this->orga;
    }

    public function setOrga(?bool $orga): self
    {
        $this->orga = $orga;

        return $this;
    }

    public function getInscrit(): ?bool
    {
        return $this->inscrit;
    }

    public function setInscrit(?bool $inscrit): self
    {
        $this->inscrit = $inscrit;

        return $this;
    }

    public function getPasInscrit(): ?bool
    {
        return $this->pasInscrit;
    }

    public function setPasInscrit(?bool $pasInscrit): self
    {
        $this->pasInscrit = $pasInscrit;

        return $this;
    }

    public function getClose(): ?bool
    {
        return $this->close;
    }

    public function setClose(?bool $close): self
    {
        $this->close = $close;

        return $this;
    }
}
