<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=ImageRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length( min="5", max="20")
     */
    private string $name;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="images")
     */
    private ?Trick $trick;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private ?bool $starImage;



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


    public function getTrick(): ?Trick
    {
        return $this->trick;
    }


    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }

    public function getStarImage(): ?bool
    {
        return $this->starImage;
    }

    public function setStarImage(?bool $starImage): self
    {
        $this->starImage = $starImage;

        return $this;
    }



}