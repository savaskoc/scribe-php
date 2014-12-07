<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verb;

class GoogleApi extends DefaultApi10a
{
    const AUTHORIZATION_URL = "https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://www.google.com/accounts/OAuthGetAccessToken";
    }

    public function getRequestTokenEndpoint()
    {
        return "https://www.google.com/accounts/OAuthGetRequestToken";
    }

    public function getAccessTokenVerb()
    {
        return Verb::GET;
    }

    public function getRequestTokenVerb()
    {
        return Verb::GET;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZATION_URL, $requestToken->getToken());
    }
}