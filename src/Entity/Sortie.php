<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sortie
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
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_debut;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_cloture;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_inscriptions_max;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     */
    private $description_infos;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $etat_sortie;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $url_photo;


   /**
    * @ORM\ManyToOne(targetEntity="Etat")
    */
    private $etat;

   /**
* @ORM\ManyToOne (targetEntity="App\Entity\Participants")
    */
     private $organisateur;


   /**
   *
   * @ORM\ManyToMany(targetEntity="App\Entity\Participants", mappedBy="sortie", cascade={"persist"})
   */
    private $participants;

    /**
     * Sortie constructor.
     * @param $participants
     */
    public function __construct()
    {
        $this->participants = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param mixed $participants
     */
    public function setParticipants($participants): void
    {
        $this->participants = $participants;
    }



   /*
    /**
    * @ORM\ManyToOne (targetEntity="App\Entity\Lieu")
    */
  //  private $lieu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateCloture(): ?\DateTimeInterface
    {
        return $this->date_cloture;
    }

    public function setDateCloture(\DateTimeInterface $date_cloture): self
    {
        $this->date_cloture = $date_cloture;

        return $this;
    }

    public function getNbInscriptionsMax(): ?int
    {
        return $this->nb_inscriptions_max;
    }

    public function setNbInscriptionsMax(int $nb_inscriptions_max): self
    {
        $this->nb_inscriptions_max = $nb_inscriptions_max;

        return $this;
    }

    public function getDescriptionInfos(): ?string
    {
        return $this->description_infos;
    }

    public function setDescriptionInfos(?string $description_infos): self
    {
        $this->description_infos = $description_infos;

        return $this;
    }

    public function getEtatSortie(): ?int
    {
        return $this->etat_sortie;
    }

    public function setEtatSortie(?int $etat_sortie): self
    {
        $this->etat_sortie = $etat_sortie;

        return $this;
    }

    public function getUrlPhoto(): ?string
    {
        return $this->url_photo;
    }

    public function setUrlPhoto(string $url_photo): self
    {
        $this->url_photo = $url_photo;

        return $this;
    }

    /**
     * @return Etat
     */
    public function getEtat(): Etat
    {
        $etat = new Etat();
        return $etat;
    }
    /**
     * @param Etat $etat
     */
  public function setEtat(Etat $etat): void
    {

        $this->etat = $etat;
    }

    public function getOrganisateur(): Participants
    {
        $orga = new Participants();
        return $orga;
    }


    public function setOrganisateur(Participants $organisateur): void
    {
        $this->organisateur = $organisateur;
    }


/*
    /**
     * @return mixed
     *//*
    public function getLieu()
    {
        return $this->lieu;
    }

    /**
     * @param mixed $lieu
     *//*
    public function setLieu($lieu): void
    {
        $this->lieu = $lieu;
    }
*/

}
