<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RessourceRepository")
 */
class Ressource
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=140)
     */
    private $name;

    /**
     * @ORM\Column(type="guid")
     */
    private $uuid;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Proposal", mappedBy="ressource")
     */
    private $proposals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\RessourceConnexe", mappedBy="primer_ressource")
     */
    private $ressource_connexe;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;


    public function __construct()
    {
        $this->proposals = new ArrayCollection();
        $this->ressource_connexe = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Proposal[]
     */
    public function getProposals(): Collection
    {
        return $this->proposals;
    }

    public function addProposal(Proposal $proposal): self
    {
        if (!$this->proposals->contains($proposal)) {
            $this->proposals[] = $proposal;
            $proposal->setRessource($this);
        }

        return $this;
    }

    public function removeProposal(Proposal $proposal): self
    {
        if ($this->proposals->contains($proposal)) {
            $this->proposals->removeElement($proposal);
            // set the owning side to null (unless already changed)
            if ($proposal->getRessource() === $this) {
                $proposal->setRessource(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|RessourceConnexe[]
     */
    public function getPrimerRessource(): Collection
    {
        return $this->primer_ressource;
    }

    public function addPrimerRessource(RessourceConnexe $primerRessource): self
    {
        if (!$this->primer_ressource->contains($primerRessource)) {
            $this->primer_ressource[] = $primerRessource;
            $primerRessource->addIdRessourceConnexe($this);
        }

        return $this;
    }

    public function removePrimerRessource(RessourceConnexe $primerRessource): self
    {
        if ($this->primer_ressource->contains($primerRessource)) {
            $this->primer_ressource->removeElement($primerRessource);
            $primerRessource->removeIdRessourceConnexe($this);
        }

        return $this;
    }

    /**
     * @return Collection|RessourceConnexe[]
     */
    public function getRessourceConnexe(): Collection
    {
        return $this->ressource_connexe;
    }

    public function addRessourceConnexe(RessourceConnexe $ressourceConnexe): self
    {
        if (!$this->ressource_connexe->contains($ressourceConnexe)) {
            $this->ressource_connexe[] = $ressourceConnexe;
            $ressourceConnexe->setPrimerRessource($this);
        }

        return $this;
    }

    public function removeRessourceConnexe(RessourceConnexe $ressourceConnexe): self
    {
        if ($this->ressource_connexe->contains($ressourceConnexe)) {
            $this->ressource_connexe->removeElement($ressourceConnexe);
            // set the owning side to null (unless already changed)
            if ($ressourceConnexe->getPrimerRessource() === $this) {
                $ressourceConnexe->setPrimerRessource(null);
            }
        }

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
}
