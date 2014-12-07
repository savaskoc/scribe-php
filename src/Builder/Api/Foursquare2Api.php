<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Extractors\JsonTokenExtractor;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class Foursquare2Api extends DefaultApi20
{
    const AUTHORIZATION_URL = "https://foursquare.com/oauth2/authenticate?client_id=%s&response_type=code&redirect_uri=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://foursquare.com/oauth2/access_token?grant_type=authorization_code";
    }

    public function getAuthorizationUrl(OAuthConfig $config)
    {
        Preconditions::checkValidUrl($config->getCallback(), "Must provide a valid url as callback. Foursquare2 does not support OOB");
        return sprintf(self::AUTHORIZATION_URL, $config->getApiKey(), URLUtils::formURLEncode($config->getCallback()));
    }

    public function getAccessTokenExtractor()
    {
        return new JsonTokenExtractor();
    }
}