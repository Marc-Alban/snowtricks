<?php


namespace App\Services;


use App\Entity\Image;
use App\Entity\Trick;
use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class TrickHelper extends AbstractController
{


    private function renamePath(UploadedFile $image): string
    {
        return md5(uniqid()).'.'.$image->guessExtension();
    }

    public function checkImageUpload(Trick $trick, ImageRepository $imageRepository): void
    {
        $images = $trick->getImages();
        $tour = 0;
        foreach ($images as $image){
            $imageId = $image->getId() ?? null;
            if(empty($image->getStarImage()) && $image->getStarImage() === null && $imageId && $tour === 0 ){
                $imageRepository->setDefaultImage($imageId);
            }
            $tour = 1;
        }
    }

    public function imageUpload(Trick $trick, array $images): void
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