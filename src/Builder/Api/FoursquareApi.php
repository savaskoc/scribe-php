<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class FoursquareApi extends DefaultApi10a
{
    const AUTHORIZATION_URL = "http://foursquare.com/oauth/authorize?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "http://foursquare.com/oauth/access_token";
    }

    public function getRequestTokenEndpoint()
    {
        return "http://foursquare.com/oauth/request_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZATION_URL, $requestToken->getToken());
    }
}