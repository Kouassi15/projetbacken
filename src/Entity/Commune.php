<?php

namespace App\Entity;

use App\Repository\CommuneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommuneRepository::class)]
class Commune
{
    #[Groups(['show_commune', 'show_hopital'])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['show_commune', 'show_hopital'])]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[Groups(['show_commune', 'show_hopital'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'commune', targetEntity: Hopital::class)]
    private Collection $hopitals;

    public function __construct()
    {
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $hopital->setCommune($this);
        }

        return $this;
    }

    public function removeHopital(Hopital $hopital): self
    {
        if ($this->hopitals->removeElement($hopital)) {
            // set the owning side to null (unless already changed)
            if ($hopital->getCommune() === $this) {
                $hopital->setCommune(null);
            }
        }

        return $this;
    }
}
