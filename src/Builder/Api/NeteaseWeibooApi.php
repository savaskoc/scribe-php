<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class NeteaseWeibooApi extends DefaultApi10a
{
    const REQUEST_TOKEN_URL = "http://api.t.163.com/oauth/request_token";
    const ACCESS_TOKEN_URL = "http://api.t.163.com/oauth/access_token";
    const AUTHORIZE_URL = "http://api.t.163.com/oauth/authorize?oauth_token=%s";
    const AUTHENTICATE_URL = "http://api.t.163.com/oauth/authenticate?oauth_token=%s";

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

    public function getAuthenticateUrl(Token $requestToken)
    {
        return sprintf(self::AUTHENTICATE_URL, $requestToken->getToken());
    }
}