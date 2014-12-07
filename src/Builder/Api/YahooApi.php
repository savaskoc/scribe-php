<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class YahooApi extends DefaultApi10a
{
    const AUTHORIZE_URL = "https://api.login.yahoo.com/oauth/v2/request_auth?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://api.login.yahoo.com/oauth/v2/get_token";
    }

    public function getRequestTokenEndpoint()
    {
        return "https://api.login.yahoo.com/oauth/v2/get_request_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }
}