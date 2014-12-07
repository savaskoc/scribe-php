<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class ConstantContactApi extends DefaultApi10a
{
    const AUTHORIZE_URL = "https://oauth.constantcontact.com/ws/oauth/confirm_access?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://oauth.constantcontact.com/ws/oauth/access_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }

    public function getRequestTokenEndpoint()
    {
        return "https://oauth.constantcontact.com/ws/oauth/request_token";
    }
}