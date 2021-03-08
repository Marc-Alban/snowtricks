<?php

namespace App\Entity;

use App\Services\Slugify;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 * @UniqueEntity(fields="name",  message="This name is already in use")
 * @UniqueEntity(fields="slug",  message="This slug is already in use")
 * @ORM\HasLifecycleCallbacks()
 */
class Trick
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\Length(min="5", max="10",minMessage="Le nom doit faire au minimum 5 caractères",maxMessage="Le nom ne doit pas faire plus de 10 caractères")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/[a-zA-Z._\p{L}-]{1,20}/",
     *     message="Not valid name: juste letter for name"
     * )
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="5", max="400",minMessage="Le nom doit faire au minimum 5 caractères",maxMessage="Le nom ne doit pas faire plus de 400 caractères")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/[a-zA-Z0-9._\p{L}-]{1,20}/",
     *     message="Not valid description"
     * )
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private string $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="trick" ,cascade={"persist", "remove"})
     */
    private ?Collection $images;


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
     */
    private ?Collection $videos;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     * @Assert\NotNull()
     * @Assert\NotBlank()
     */
    private Category $category;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="trick")
     */
    private Collection $comments;


    public function __construct()
    {
       $this->videos = new ArrayCollection();
       $this->images = new ArrayCollection();
       $this->comments = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }


    public function getSlug(): string
    {
        return $this->slug;
    }


    public function setSlug($slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Initialize slug before persist or update
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function initializeSlug(): void
    {
        if (empty($this->slug)) {
            $slug = slugify::slug($this->name);
            $this->setSlug($slug);
        }
    }

    /**
     * @return null|Collection
     */
    public function getImages(): ?Collection
    {
        return $this->images;
    }

    public function addImage(?Image $image): ?self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(?Video $image): ?self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return null|Collection
     */
    public function getVideos(): ?Collection
    {
        return $this->videos;
    }

    public function addVideo(?Video $video): ?self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(?Video $video): ?self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

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
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

}