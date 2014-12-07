<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class VimeoApi extends DefaultApi10a
{
    const AUTHORIZATION_URL = "http://vimeo.com/oauth/authorize?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "http://vimeo.com/oauth/access_token";
    }

    public function getRequestTokenEndpoint()
    {
        return "http://vimeo.com/oauth/request_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZATION_URL, $requestToken->getToken());
    }
}