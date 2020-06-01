<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VilleRepository")
 */
class Ville
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
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Quartier", mappedBy="Villes")
     */
    private $quartier;


    public function __toString()
    {
        return $this->ville;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->User = new ArrayCollection();
        $this->quartier = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVille() 
    {
        return $this->ville;
    }

    public function setVille( $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Quartier[]
     */
    public function getQuartier(): Collection
    {
        return $this->quartier;
    }

    public function addQuartier(Quartier $quartier): self
    {
        if (!$this->quartier->contains($quartier)) {
            $this->quartier[] = $quartier;
            $quartier->setVilles($this);
        }

        return $this;
    }

    public function removeQuartier(Quartier $quartier): self
    {
        if ($this->quartier->contains($quartier)) {
            $this->quartier->removeElement($quartier);
            // set the owning side to null (unless already changed)
            if ($quartier->getVilles() === $this) {
                $quartier->setVilles(null);
            }
        }

        return $this;
    }


}
