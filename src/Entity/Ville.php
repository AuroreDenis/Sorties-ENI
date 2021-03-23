<?php

namespace App\Entity;

use App\Repository\VillesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=VillesRepository::class)
 */
class Ville
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"liste_ville"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     *
     * @Groups({"liste_ville"})
     */
    private $nom_ville;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $code_postal;

    /**
     * @ORM\OneToMany(targetEntity=Lieu::class, cascade={"persist", "remove"}, mappedBy="ville")
     */
    private $lieux;

    public function __construct()
    {
        $this->lieux = new ArrayCollection();
    }
    // ...

    public function getLieux()
    {
        return $this->lieux;
    }

    public function addLieu(Lieu $lieu)
    {
        $this->lieux->add($lieu);
        $lieu->setVille($this);
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomVille(): ?string
    {
        return $this->nom_ville;
    }

    public function setNomVille(string $nom_ville): self
    {
        $this->nom_ville = $nom_ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }
}
