<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AnnonceRepository")
 * @Vich\Uploadable
 * @UniqueEntity(
 * fields= {"annonceTitle"},
 * message= "Le titre que vous avez indiqué est déà utilisé !")
 */
class Annonce
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
    private $annonceTitle;

    /**
     * @ORM\Column(type="text")
     */
    private $annonceDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private $annonceOrder=1;

    /**
     * @ORM\Column(type="boolean")
     */
    private $annoncePublier=true;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $annoncePicture;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="annonce", fileNameProperty="annoncePicture", size="imageSize")
     * @var File|null
     * @Assert\Image(
     * maxWidth = 800,
     * maxWidthMessage = "Votre image doit faire 800px de largeur maximum",
     * mimeTypes= {"image/jpeg", "image/png", "image/gif"},
     * mimeTypesMessage = "Formats autorisés : .jpg, .jpeg, .gif, .png"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="integer")
     *
     * @var int|null
     */
    private $imageSize=1;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTimeInterface|null
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $budget;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="article", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorys;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $City;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("^[0-9]{5}$/")
     */
    private $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userannonce", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;


    public function __construct()
    {
        $this->comments = new ArrayCollection(); 


    
    }

    public function __toString(){
        return $this->budget;
                $this->annonceDescription;
                $this->annonceTitle;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnnonceTitle()
    {
        return $this->annonceTitle;
    }

    public function setAnnonceTitle( $annonceTitle): self
    {
        $this->annonceTitle = $annonceTitle;

        return $this;
    }



    public function getAnnonceOrder(): ?int
    {
        return $this->annonceOrder;
    }

    public function setAnnonceOrder(int $annonceOrder): self
    {
        $this->annonceOrder = $annonceOrder;

        return $this;
    }

    public function getAnnoncePublier(): ?bool
    {
        return $this->annoncePublier;
    }

    public function setAnnoncePublier(bool $annoncePublier): self
    {
        $this->annoncePublier = $annoncePublier;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getAnnoncePicture()
    {
        return $this->annoncePicture;
    }

    public function setAnnoncePicture( $annoncePicture): self
    {
        $this->annoncePicture = $annoncePicture;

        return $this;
    }

    public function getAnnonceDescription()
    {
        return $this->annonceDescription;
    }

    public function setAnnonceDescription( $annonceDescription): self
    {
        $this->annonceDescription = $annonceDescription;

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getBudget()
    {
        return $this->budget;
    }

    public function setBudget( $budget): self
    {
        $this->budget = $budget;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }



    /**
     * Get the value of categorys
     */ 
    public function getCategorys()
    {
        return $this->categorys;
    }

    /**
     * Set the value of categorys
     *
     * @return  self
     */ 
    public function setCategorys($categorys)
    {
        $this->categorys = $categorys;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->City;
    }

    public function setCity(string $City): self
    {
        $this->City = $City;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getUsers(): ?User
    {
        return $this->users;
    }

    public function setUsers(?User $users): self
    {
        $this->users = $users;

        return $this;
    }



}
