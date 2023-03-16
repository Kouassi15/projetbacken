<?php

namespace App\Entity;

use App\Repository\SpecialiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SpecialiteRepository::class)]
class Specialite
{
    #[Groups(['show_specialite', 'show_medecin', 'show_hopital'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['show_specialite', 'show_medecin', 'show_hopital'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['show_specialite', 'show_hopital'])]
    #[ORM\ManyToMany(targetEntity: Medecin::class, mappedBy: 'specialite')]
    private Collection $medecins;

    #[Groups(['show_specialite'])]
    #[ORM\ManyToMany(targetEntity: Hopital::class, mappedBy: 'specialite')]
    private Collection $hopitals;

    public function __construct()
    {
        $this->medecins = new ArrayCollection();
        $this->hopitals = new ArrayCollection();
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
     * @return Collection<int, Medecin>
     */
    public function getMedecins(): Collection
    {
        return $this->medecins;
    }

    public function addMedecin(Medecin $medecin): self
    {
        if (!$this->medecins->contains($medecin)) {
            $this->medecins->add($medecin);
            $medecin->addSpecialite($this);
        }

        return $this;
    }

    public function removeMedecin(Medecin $medecin): self
    {
        if ($this->medecins->removeElement($medecin)) {
            $medecin->removeSpecialite($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Hopital>
     */
    public function getHopitals(): Collection
    {
        return $this->hopitals;
    }

    public function addHopital(Hopital $hopital): self
    {
        if (!$this->hopitals->contains($hopital)) {
            $this->hopitals->add($hopital);
            $hopital->addSpecialite($this);
        }

        return $this;
    }

    public function removeHopital(Hopital $hopital): self
    {
        if ($this->hopitals->removeElement($hopital)) {
            $hopital->removeSpecialite($this);
        }

        return $this;
    }
}
