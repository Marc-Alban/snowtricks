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
        $images = $imageRepository->findImageById($trick->getId());
        $imageByStar = $imageRepository->findImageByIdTrick($trick->getId());
            if(empty($imageByStar) === true){
                $tour = 0;
                foreach ($images as $image){
                    if($tour === 0){
                        $imageRepository->setDefaultImage($image->getId());
                        $tour = 1;
                    }
                }
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