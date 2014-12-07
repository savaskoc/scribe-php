<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;

class DropBoxApi extends DefaultApi10a
{
    public function getAccessTokenEndpoint()
    {
        return "https://api.dropbox.com/0/oauth/access_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf("https://www.dropbox.com/0/oauth/authorize?oauth_token=%s", $requestToken->getToken());
    }

    public function getRequestTokenEndpoint()
    {
        return "https://api.dropbox.com/0/oauth/request_token";
    }
}