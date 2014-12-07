<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class LoveFilmApi extends DefaultApi10a
{
    const REQUEST_TOKEN_URL = "http://openapi.lovefilm.com/oauth/request_token";
    const ACCESS_TOKEN_URL = "http://openapi.lovefilm.com/oauth/access_token";
    const AUTHORIZE_URL = "https://www.lovefilm.com/activate?oauth_token=%s";

    public function getRequestTokenEndpoint()
    {
        return self::REQUEST_TOKEN_URL;
    }

    public function getAccessTokenEndpoint()
    {
        return self::ACCESS_TOKEN_URL;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }
}