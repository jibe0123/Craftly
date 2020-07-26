<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeRepository::class)
 */
class Attribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $unit;

    /**
     * @ORM\OneToMany(targetEntity=ProposalAttribute::class, mappedBy="attribute")
     */
    private $proposalAttributes;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="attributes")
     */
    private $categories;

    public function __construct()
    {
        $this->proposalAttributes = new ArrayCollection();
        $this->categories = new ArrayCollection();
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

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * @return Collection|ProposalAttribute[]
     */
    public function getProposalAttributes(): Collection
    {
        return $this->proposalAttributes;
    }

    public function addProposalAttribute(ProposalAttribute $proposalAttribute): self
    {
        if (!$this->proposalAttributes->contains($proposalAttribute)) {
            $this->proposalAttributes[] = $proposalAttribute;
            $proposalAttribute->setAttribute($this);
        }

        return $this;
    }

    public function removeProposalAttribute(ProposalAttribute $proposalAttribute): self
    {
        if ($this->proposalAttributes->contains($proposalAttribute)) {
            $this->proposalAttributes->removeElement($proposalAttribute);
            // set the owning side to null (unless already changed)
            if ($proposalAttribute->getAttribute() === $this) {
                $proposalAttribute->setAttribute(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addAttribute($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeAttribute($this);
        }

        return $this;
    }
}
