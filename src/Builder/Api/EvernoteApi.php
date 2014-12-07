<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verb;

class EvernoteApi extends DefaultApi10a
{
    const AUTHORIZATION_URL = "https://www.evernote.com/OAuth.action?oauth_token=%s";

    public function getRequestTokenVerb()
    {
        return Verb::GET;
    }

    public function getRequestTokenEndpoint()
    {
        return "https://www.evernote.com/oauth";
    }

    public function getAccessTokenVerb()
    {
        return Verb::GET;
    }

    public function getAccessTokenEndpoint()
    {
        return "https://www.evernote.com/oauth";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZATION_URL, $requestToken->getToken());
    }
}

class EvernoteApiSandbox extends EvernoteApi
{
    const SANDBOX_URL = "https://sandbox.evernote.com/oauth";

    public function getRequestTokenEndpoint()
    {
        return self::SANDBOX_URL;
    }

    public function getAccessTokenEndpoint()
    {
        return self::SANDBOX_URL;
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::SANDBOX_URL . "?oauth_token=%s", $requestToken->getToken());
    }
}