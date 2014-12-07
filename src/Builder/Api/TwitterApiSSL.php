<?php
namespace Hyperion\Scribe\Builder\Api;

class TwitterApiSSL extends TwitterApi
{
    public function getAccessTokenEndpoint()
    {
        return "https://" . self::ACCESS_TOKEN_RESOURCE;
    }

    public function getRequestTokenEndpoint()
    {
        return "https://" . self::REQUEST_TOKEN_RESOURCE;
    }
}