<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class LinkedInApi extends DefaultApi10a
{
    const AUTHORIZE_URL = "https://api.linkedin.com/uas/oauth/authorize?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://api.linkedin.com/uas/oauth/accessToken";
    }

    public function getRequestTokenEndpoint()
    {
        return "https://api.linkedin.com/uas/oauth/requestToken";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZE_URL, $requestToken->getToken());
    }
}