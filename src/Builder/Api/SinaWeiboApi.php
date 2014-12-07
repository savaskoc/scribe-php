<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class SinaWeiboApi extends DefaultApi10a
{
    const REQUEST_TOKEN_URL = "http://api.t.sina.com.cn/oauth/request_token";
    const ACCESS_TOKEN_URL = "http://api.t.sina.com.cn/oauth/access_token";
    const AUTHORIZE_URL = "http://api.t.sina.com.cn/oauth/authorize?oauth_token=%s";

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