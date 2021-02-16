<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @Assert\Image(
     *  mimeTypes= {"image/jpeg", "image/jpg", "image/png"},
     *  mimeTypesMessage = "Le fichier ne possède pas une extension valide ! Veuillez insérer une image en .jpg, .jpeg ou .png",
     *  minWidth = 500,
     *  minWidthMessage = "La largeur de cette image est trop petite",
     *  maxWidth = 3000,
     *  maxWidthMessage = "La largeur de cette image est trop grande",
     *  minHeight = 282,
     *  minHeightMessage = "La hauteur de cette image est trop petite",
     *  maxHeight = 1687,
     *  maxHeightMessage ="La hauteur de cette image est trop grande",
     *  )
     */
    private UploadedFile $file;

    private string $path;


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

    public function getFile(): UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }


    public function setPath($path): void
    {
        $this->path = $path;
    }

    /**
     * @ORM\PreFlush()
     */
    public function handle(): void
    {
        if($this->file === null){
            return;
        }

        if($this->id){
            unlink($this->path.'/'.$this->name);
        }
        $name = $this->createName($this->file);
        //deplacement du fichier
        $this->file->move($this->path,$name);
        //donne le nom à l'image
        $this->setName($name);
    }

    private function createName(): string
    {
        //creer un nom unique
        return md5(uniqid()).'.'.$this->file->getClientOriginalName();
    }

}