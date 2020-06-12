<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
       * @var \DateTime $created_at
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $creaTedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Annonce", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $article;

    /**
      * @Gedmo\Slug(fields={"author"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreaTedAt(): ?\DateTimeInterface
    {
        return $this->creaTedAt;
    }


    public function getArticle(): ?Annonce
    {
        return $this->article;
    }

    public function setArticle(?Annonce $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

  
}
