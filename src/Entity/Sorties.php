<?php

namespace App\Entity;

use App\Repository\SortiesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SortiesRepository::class)
 */
class Sorties
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Etats")
     */
    private $etat;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Participants")
     */
    private $organisateur;


    /**
     * @var ArrayCollection $inscriptions
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Inscriptions", mappedBy="sortie", cascade={"persist", "remove", "merge"})
     */
    private $inscriptions;

    /**
     * @param Inscriptions $inscriptions
     */
    public function addInscriptions(Inscriptions $inscriptions) {
        $inscriptions->setSortie($this);

        // Si l'objet fait déjà partie de la collection on ne l'ajoute pas
        if (!$this->$inscriptions->contains($inscriptions)) {
            $this->$inscriptions->add($inscriptions);
        }
    }

    /**
     * @return ArrayCollection $participants
     */
    public function getInscriptions() {
        return $this->inscriptions;
    }

    public function __construct() {
        $this->inscriptions = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\Lieux")
     */
    private $lieux;

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
     * @return Etats
     */
    public function getEtat(): Etats
    {
        return $this->etat;
    }

    /**
     * @param Etats $etat
     */
    public function setEtat(Etats $etat): void
    {
        $this->etat = $etat;
    }

    /**
     * @return Participants
     */
    public function getOrganisateur(): Participants
    {
        return $this->organisateur;
    }

    /**
     * @param Participants $organisateur
     */
    public function setOrganisateur(Participants $organisateur): void
    {
        $this->organisateur = $organisateur;
    }



    /**
     * @return mixed
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * @param mixed $lieux
     */
    public function setLieux($lieux): void
    {
        $this->lieux = $lieux;
    }


}
