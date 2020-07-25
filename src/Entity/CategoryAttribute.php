<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryAttributeRepository")
 */
class CategoryAttribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="attributes")
     */
    private $Category;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $value;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $unity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ProposalAttribute", mappedBy="category_attribute")
     */
    private $proposalAttributes;

    public function __construct()
    {
        $this->proposalAttributes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?Category
    {
        return $this->Category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->Category = $Category;

        return $this;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUnity(): ?string
    {
        return $this->unity;
    }

    public function setUnity(?string $unity): self
    {
        $this->unity = $unity;

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
            $proposalAttribute->setCategoryAttribute($this);
        }

        return $this;
    }

    public function removeProposalAttribute(ProposalAttribute $proposalAttribute): self
    {
        if ($this->proposalAttributes->contains($proposalAttribute)) {
            $this->proposalAttributes->removeElement($proposalAttribute);
            // set the owning side to null (unless already changed)
            if ($proposalAttribute->getCategoryAttribute() === $this) {
                $proposalAttribute->setCategoryAttribute(null);
            }
        }

        return $this;
    }
}
