<?php

namespace App\Entity;

use App\Repository\VilleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VilleRepository::class)]
class Ville
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?int $codePostal = null;

    #[ORM\OneToMany(mappedBy: 'ville', targetEntity: lieu::class)]
    private Collection $localite;

    public function __construct()
    {
        $this->localite = new ArrayCollection();
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

    public function getCodePostal(): ?int
    {
        return $this->codePostal;
    }

    public function setCodePostal(int $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * @return Collection<int, lieu>
     */
    public function getLocalite(): Collection
    {
        return $this->localite;
    }

    public function addLocalite(lieu $localite): self
    {
        if (!$this->localite->contains($localite)) {
            $this->localite->add($localite);
            $localite->setVille($this);
        }

        return $this;
    }

    public function removeLocalite(lieu $localite): self
    {
        if ($this->localite->removeElement($localite)) {
            // set the owning side to null (unless already changed)
            if ($localite->getVille() === $this) {
                $localite->setVille(null);
            }
        }

        return $this;
    }
}
