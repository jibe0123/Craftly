<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProposalAttributeRepository")
 */
class ProposalAttribute
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
    private $value;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $unity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Proposal", inversedBy="attributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $proposal;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryAttribute", inversedBy="proposalAttributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_attribute;

    public function getId(): ?int
    {
        return $this->id;
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

    public function setUnity(string $unity): self
    {
        $this->unity = $unity;

        return $this;
    }

    public function getProposal(): ?Proposal
    {
        return $this->proposal;
    }

    public function setProposal(?Proposal $proposal): self
    {
        $this->proposal = $proposal;

        return $this;
    }

    public function getCategoryAttribute(): ?CategoryAttribute
    {
        return $this->category_attribute;
    }

    public function setCategoryAttribute(?CategoryAttribute $category_attribute): self
    {
        $this->category_attribute = $category_attribute;

        return $this;
    }
}
