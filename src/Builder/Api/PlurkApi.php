<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class PlurkApi extends DefaultApi10a
{
    const REQUEST_TOKEN_URL = "http://www.plurk.com/OAuth/request_token";
    const AUTHORIZE_URL = "http://www.plurk.com/OAuth/authorize?oauth_token=%s";
    const ACCESS_TOKEN_URL = "http://www.plurk.com/OAuth/access_token";

    public function getRequestTokenEndpoint()
    {
        return self::REQUEST_TOKEN_URL;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }

    public function getAccessTokenEndpoint()
    {
        return self::ACCESS_TOKEN_URL;
    }
}