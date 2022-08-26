<?php

namespace App\Entity;

use App\Repository\SortieRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SortieRepository::class)]
class Sortie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureDebut = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $duree = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateLimiteInscription = null;

    #[ORM\Column]
    private ?int $nombreInscriptionMax = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $infosSortie = null;

    #[ORM\ManyToOne(inversedBy: 'site')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Campus $campus = null;

    #[ORM\ManyToOne(inversedBy: 'organisateur')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: user::class, inversedBy: 'sorties')]
    private Collection $inscription;

    #[ORM\ManyToOne(inversedBy: 'destination')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lieu $lieu = null;

    public function __construct()
    {
        $this->inscription = new ArrayCollection();
    }

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

    public function getDateHeureDebut(): ?\DateTimeInterface
    {
        return $this->dateHeureDebut;
    }
    /*
     * Création d'une méthode pour avoir un string date et pas un objet datetime
     */
     public function getDebut(): string
     {

         $date=DateTime::createFromFormat("'Y-M-d H:i:s",$this->dateHeureDebut);
         return $this->$date;
     }

    public function setDateHeureDebut(\DateTimeInterface $dateHeureDebut): self
    {
        $this->dateHeureDebut = $dateHeureDebut;

        return $this;
    }

    public function getDuree(): ?\DateTimeInterface
    {
        return $this->duree;
    }

    public function setDuree(\DateTimeInterface $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateLimiteInscription(): ?\DateTimeInterface
    {
        return $this->dateLimiteInscription;
    }
    /*
     * Création d'une méthode pour avoir un string date et pas un objet datetime
     */
    public function getlimite(): string
    {
        $date=\DateTime::createFromFormat("'Y-M-d H:i:s",$this->dateLimiteInscription);
        return $this->$date;
    }

    public function setDateLimiteInscription(\DateTimeInterface $dateLimiteInscription): self
    {
        $this->dateLimiteInscription = $dateLimiteInscription;

        return $this;
    }

    public function getNombreInscriptionMax(): ?int
    {
        return $this->nombreInscriptionMax;
    }

    public function setNombreInscriptionMax(int $nombreInscriptionMax): self
    {
        $this->nombreInscriptionMax = $nombreInscriptionMax;

        return $this;
    }

    public function getInfosSortie(): ?string
    {
        return $this->infosSortie;
    }

    public function setInfosSortie(?string $infosSortie): self
    {
        $this->infosSortie = $infosSortie;

        return $this;
    }

    public function getCampus(): ?Campus
    {
        return $this->campus;
    }

    public function setCampus(?Campus $campus): self
    {
        $this->campus = $campus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, user>
     */
    public function getInscription(): Collection
    {
        return $this->inscription;
    }

    public function addInscription(user $inscription): self
    {
        if (!$this->inscription->contains($inscription)) {
            $this->inscription->add($inscription);
        }

        return $this;
    }

    public function removeInscription(user $inscription): self
    {
        $this->inscription->removeElement($inscription);

        return $this;
    }

    public function getLieu(): ?Lieu
    {
        return $this->lieu;
    }

    public function setLieu(?Lieu $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }
}
