<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampusRepository::class)
 */
class Campus
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nom_campus;


    /**
     * @var ArrayCollection $participants
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Participants", mappedBy="campus", cascade={"persist", "remove", "merge"})
     */
    private $participants;



    /**
     * @param Participants $participants
     */
    public function addParticipants(Participants $participants) {
        $participants->setCampus($this);

        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->$participants->contains($participants)) {
            $this->$participants->add($participants);
        }
    }

    /**
     * @return ArrayCollection $participants
     */
    public function getParticipants() {
        return $this->participants;
    }

    public function __construct() {
        $this->participants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCampus(): ?string
    {
        return $this->nom_campus;
    }

    public function setNomCampus(string $nom_campus): self
    {
        $this->nom_campus = $nom_campus;

        return $this;
    }
}
