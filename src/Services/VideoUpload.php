<?php


namespace App\Services;


class VideoUpload
{
    private $urlYoutube = "https://www.youtube.com/embed/";

    public function verifyUrl(string $url)
    {
        parse_str( parse_url( $url, PHP_URL_QUERY ), $urlGood );
        $urlEnd = $this->urlYoutube.$urlGood;
        dd($urlEnd);
    }
}