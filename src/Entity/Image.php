<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ImageRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass=ImageRepository::class)
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



    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Trick", inversedBy="images")
     */
    private ?Trick $trick;

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

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

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


    private function createName(): string
    {
        //Créer un nom unique
        return md5(uniqid()).$this->file->getClientOriginalName();
    }

    /**
     * @ORM\PreFlush()
     */
    public function handle()
    {
        if($this->file === null){
            return;
        }

        if(file_exists($this->id)){
            unlink($this->path.'/'.$this->name);
        }
        //Récupère le file soumis
        $name = $this->createName();
        //Donne le nom à l'image
        $this->setName($name);
        //Déplace le fichier
        $this->file->move($this->path,$name);
    }

}