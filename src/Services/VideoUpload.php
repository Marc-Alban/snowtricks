<?php


namespace App\Services;


class VideoUpload
{

    private $urlYoutube = "https://www.youtube.com/embed/";

    public function extractPlatformFromUrl(string $url)
    {
        return parse_url($url);
    }
}