<?php


    namespace App\Entity;
    
    use Doctrine\ORM\Mapping as ORM;
    
    /**
     * @ORM\Entity(repositoryClass="App\Repository\QuartierRepository")
     */
    class Quartier
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
        private $nomQuartier;

        /**
         * @ORM\ManyToOne(targetEntity="App\Entity\Ville", inversedBy="quartier")
         */
        private $Villes;

    
        public function __toString()
        {
            return $this->nomQuartier;
        }
    
    
        public function getId(): ?int
        {
            return $this->id;
        }
    
        public function getNomQuartier()
        {
            return $this->nomQuartier;
        }
    
        public function setNomQuartier( $nomQuartier): self
        {
            $this->nomQuartier = $nomQuartier;
    
            return $this;
        }

        public function getVilles(): ?Ville
        {
            return $this->Villes;
        }

        public function setVilles(?Ville $Villes): self
        {
            $this->Villes = $Villes;

            return $this;
        }

    }
