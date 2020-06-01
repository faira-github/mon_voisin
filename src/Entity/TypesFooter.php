<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypesFooterRepository")
 */
class TypesFooter
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
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ConditionFooter", mappedBy="category")
     */
    private $conditionFooters;

    public function __construct()
    {
        $this->conditionFooters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|ConditionFooter[]
     */
    public function getConditionFooters(): Collection
    {
        return $this->conditionFooters;
    }

    public function addConditionFooter(ConditionFooter $conditionFooter): self
    {
        if (!$this->conditionFooters->contains($conditionFooter)) {
            $this->conditionFooters[] = $conditionFooter;
            $conditionFooter->setCategory($this);
        }

        return $this;
    }

    public function removeConditionFooter(ConditionFooter $conditionFooter): self
    {
        if ($this->conditionFooters->contains($conditionFooter)) {
            $this->conditionFooters->removeElement($conditionFooter);
            // set the owning side to null (unless already changed)
            if ($conditionFooter->getCategory() === $this) {
                $conditionFooter->setCategory(null);
            }
        }

        return $this;
    }
}
