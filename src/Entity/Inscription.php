<?php

namespace App\Entity;

use App\Repository\InscriptionsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionsRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_inscription;

//, inversedBy="inscriptions", cascade={"persist", "merge", "remove"}) -> à ajouter pour relation biderectionnelle

    /**
     *
     * @ORM\ManyToOne (targetEntity="App\Entity\Sortie")
     */
    private $sortie;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Participants")
     */
    private $participant;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->date_inscription;
    }

    public function setDateInscription(\DateTimeInterface $date_inscription): self
    {
        $this->date_inscription = $date_inscription;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSortie()
    {
        return $this->sortie;
    }

    /**
     * @param mixed $sortie
     */
    public function setSortie($sortie): void
    {
        $this->sortie = $sortie;
    }

    /**
     * @return mixed
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * @param mixed $participant
     */
    public function setParticipant($participant): void
    {
        $this->participant = $participant;
    }


}
