<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RessourceConnexeRepository")
 */
class RessourceConnexe
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
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ressource", inversedBy="ressource_connexe")
     * @ORM\JoinColumn(nullable=false)
     */
    private $primer_ressource;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPrimerRessource(): ?Ressource
    {
        return $this->primer_ressource;
    }

    public function setPrimerRessource(?Ressource $primer_ressource): self
    {
        $this->primer_ressource = $primer_ressource;

        return $this;
    }
}
