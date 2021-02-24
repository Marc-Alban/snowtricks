<?php


namespace App\Services;



use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class YoutubeValidator extends AbstractController
{

    /**
     * @param string $value
     * @return mixed
     */
    public function doClean(string $value): mixed
    {
        $pattern = "/(http(s)?:\/\/)?(?:youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=)([^#\&\?]*).*/";

        preg_match($pattern, $value, $matches);

        if (empty($matches[3]))
        {
            throw $this->createNotFoundException('l\'url n\'est pas bonne !');
        }
        return $matches[3];
    }

    /**
     * @param Video $video
     */
    public function setVideoUrl(Video $video): void
    {
        $video->setUrl('https://www.youtube.com/embed/'.$this->doClean($video->getUrl()));
    }
}