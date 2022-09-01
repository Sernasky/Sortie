<?php

namespace App\Entity;

use App\Repository\CampusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampusRepository::class)]
class Campus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: Sortie::class)]
    private Collection $site;

    #[ORM\OneToMany(mappedBy: 'campus', targetEntity: User::class)]
    private Collection $rattacher;

    public function __construct()
    {
        $this->site = new ArrayCollection();
        $this->rattacher = new ArrayCollection();
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

    /**
     * @return Collection<int, Sortie>
     */
    public function getSite(): Collection
    {
        return $this->site;
    }

    public function addSite(Sortie $site): self
    {
        if (!$this->site->contains($site)) {
            $this->site->add($site);
            $site->setCampus($this);
        }
        return $this;
    }

    public function removeSite(Sortie $site): self
    {
        if ($this->site->removeElement($site)) {
            // set the owning side to null (unless already changed)
            if ($site->getCampus() === $this) {
                $site->setCampus(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getRattacher(): Collection
    {
        return $this->rattacher;
    }

    public function addRattacher(User $rattacher): self
    {
        if (!$this->rattacher->contains($rattacher)) {
            $this->rattacher->add($rattacher);
            $rattacher->setCampus($this);
        }
        return $this;
    }

    public function removeRattacher(User $rattacher): self
    {
        if ($this->rattacher->removeElement($rattacher)) {
            // set the owning side to null (unless already changed)
            if ($rattacher->getCampus() === $this) {
                $rattacher->setCampus(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->nom;
    }
}
