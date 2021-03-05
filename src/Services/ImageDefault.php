<?php


namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ImageDefault extends AbstractController
{

    public function index($value): bool
    {
        $filename = $this->getParameter('images_directory');

            if(file_exists($filename.$value)){
                return true;
            }
            return false;
    }

}