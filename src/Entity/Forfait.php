<?php

namespace App\Entity;

use App\Repository\ForfaitRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ForfaitRepository::class)
 */
class Forfait
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    /**
     * @ORM\ManyToOne(targetEntity=Fiche::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $fiche;

    /**
     * @ORM\ManyToOne(targetEntity=TypeFrais::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }

    public function getFiche(): ?Fiche
    {
        return $this->fiche;
    }

    public function setFiche(?Fiche $fiche): self
    {
        $this->fiche = $fiche;

        return $this;
    }

    public function getType(): ?TypeFrais
    {
        return $this->type;
    }

    public function setType(?TypeFrais $type): self
    {
        $this->type = $type;

        return $this;
    }

    
}
