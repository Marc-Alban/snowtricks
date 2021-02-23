<?php


namespace App\Services;


use App\Entity\Image;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickHelper extends AbstractController
{

    private function renamePath(UploadedFile $image): string
    {
        return md5(uniqid()).'.'.$image->guessExtension();
    }

    public function imageUpload(Trick $trick, array $images)
    {
        foreach ($images as $image)
        {
            $fileName = $this->renamePath($image);
            $image->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $img = new Image();
            $img->setName($fileName);
            $trick->addImage($img);
        }
    }

}