<?php

namespace App\Entity;

use App\Services\Slugify;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
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
     * @ORM\Column(type="string", length=100)
     * @Assert\Length(max=100, maxMessage="Le nom ne doit pas faire plus de 100 caractères")
     */
    private string $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=20, minMessage="La description doit faire au moins 20 caractères")
     */
    private string $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private DateTimeInterface $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private DateTimeInterface $updatedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Image", mappedBy="trick", cascade={"persist", "remove"})
     * @Assert\Valid()
     */
    private Collection $images;

//    /**
//     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick", cascade={"persist", "remove"})
//     */
//    private ?Collection $videos;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     */
    private Category $category;


    public function __construct()
    {
        $this->images = new ArrayCollection();
//        $this->videos = new ArrayCollection();
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

    public function getUpdatedAt(): DateTimeInterface
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
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setTrick($this);
        }

        return $this;
    }

    public function removeImage(Image $image): self
    {
        if ($this->images->contains($image)) {
            $this->images->removeElement($image);
            if ($image->getTrick() === $this) {
                $image->setTrick(null);
            }
        }

        return $this;
    }

//    /**
//     * @return null|Collection
//     */
//    public function getVideos(): ?Collection
//    {
//        return $this->videos;
//    }
//
//    public function addVideo(?Video $video): ?self
//    {
//        if (!$this->videos->contains($video)) {
//            $this->videos[] = $video;
//            $video->setTrick($this);
//        }
//
//        return $this;
//    }
//
//    public function removeVideo(?Video $video): ?self
//    {
//        if ($this->videos->contains($video)) {
//            $this->videos->removeElement($video);
//            if ($video->getTrick() === $this) {
//                $video->setTrick(null);
//            }
//        }
//
//        return $this;
//    }
//

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

}