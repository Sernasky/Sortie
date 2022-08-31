<?php

namespace App\Entity;

use App\Repository\EtatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EtatRepository::class)]
class Etat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @Assert\Choice(choices={"En création","Ouverte","Clôturée","Activité en cours","Activité terminée","Annulée","Activité historisée"})
     * @ORM\Column(type="string", length=50)
     */
    #[ORM\Column(length: 50)]
    private ?string $libelle = null;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Sortie::class)]
    private Collection $statut;

    #[ORM\OneToMany(mappedBy: 'etat', targetEntity: Sortie::class)]
    private Collection $suivi;



    public function __construct()
    {
        $this->sorties = new ArrayCollection();
        $this->statut = new ArrayCollection();
        $this->suivi = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

//    public function getLibelle(): ?string
//    {
//        return $this->libelle;
//    }
//
//    public function setLibelle(string $libelle): self
//    {
//        $this->libelle = $libelle;
//
//        return $this;
//    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSorties(): Collection
    {
        return $this->sorties;
    }

    public function addSorty(Sortie $sorty): self
    {
        if (!$this->sorties->contains($sorty)) {
            $this->sorties->add($sorty);
            $sorty->setEtat($this);
        }

        return $this;
    }

    public function removeSorty(Sortie $sorty): self
    {
        if ($this->sorties->removeElement($sorty)) {
            // set the owning side to null (unless already changed)
            if ($sorty->getEtat() === $this) {
                $sorty->setEtat(null);
            }
        }

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getStatut(): Collection
    {
        return $this->statut;
    }

    public function addStatut(Sortie $statut): self
    {
        if (!$this->statut->contains($statut)) {
            $this->statut->add($statut);
            $statut->setEtat($this);
        }

        return $this;
    }

    public function removeStatut(Sortie $statut): self
    {
        if ($this->statut->removeElement($statut)) {
            // set the owning side to null (unless already changed)
            if ($statut->getEtat() === $this) {
                $statut->setEtat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Sortie>
     */
    public function getSuivi(): Collection
    {
        return $this->suivi;
    }

    public function addSuivi(Sortie $suivi): self
    {
        if (!$this->suivi->contains($suivi)) {
            $this->suivi->add($suivi);
            $suivi->setEtat($this);
        }

        return $this;
    }

    public function removeSuivi(Sortie $suivi): self
    {
        if ($this->suivi->removeElement($suivi)) {
            // set the owning side to null (unless already changed)
            if ($suivi->getEtat() === $this) {
                $suivi->setEtat(null);
            }
        }

        return $this;
    }
}
