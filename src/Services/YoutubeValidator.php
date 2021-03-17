<?php


namespace App\Services;



use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class YoutubeValidator extends AbstractController
{

    /**
     * @param string $value
     * @return string
     */
    public function doClean(string $value): string
    {
        $pattern = "/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/";

        preg_match($pattern, $value, $matches);

        if (empty($matches[5]))
        {
            throw $this->createNotFoundException('l\'url n\'est pas bonne !');
        }
        return $matches[5];
    }

    /**
     * @param Video $video
     * @param string $url
     */
    public function setVideoUrl(Video $video, ?string $url): void
    {
        if($url !== null) {
            $video->setUrl('https://www.youtube.com/embed/' .$this->doClean($url));
        }elseif ($url === null){
            $video->setUrl('https://www.youtube.com/embed/' . $this->doClean($video->getUrl()));
        }
    }
}