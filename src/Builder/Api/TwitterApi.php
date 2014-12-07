<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class TwitterApi extends DefaultApi10a
{
    const AUTHORIZE_URL = "https://api.twitter.com/oauth/authorize?oauth_token=%s";
    const REQUEST_TOKEN_RESOURCE = "api.twitter.com/oauth/request_token";
    const ACCESS_TOKEN_RESOURCE = "api.twitter.com/oauth/access_token";

    public function getAccessTokenEndpoint()
    {
        return "http://" . self::ACCESS_TOKEN_RESOURCE;
    }

    public function getRequestTokenEndpoint()
    {
        return "http://" . self::REQUEST_TOKEN_RESOURCE;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }
}