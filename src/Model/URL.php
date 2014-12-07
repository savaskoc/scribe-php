<?php
namespace Hyperion\Scribe\Model;
class URL
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function openConnection()
    {
        return new HttpURLConnectionCurl($this->url);
    }

    public function getQuery()
    {
        return (strpos($this->url, '?') !== false) ? substr($this->url, strpos($this->url, '?') + 1) : "";
    }
}