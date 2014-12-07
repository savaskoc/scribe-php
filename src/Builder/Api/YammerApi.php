<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Services\PlaintextSignatureService;

class YammerApi extends DefaultApi10a
{
    const AUTHORIZATION_URL = "'https://www.yammer.com/oauth/authorize?oauth_token=%s'";

    public function getRequestTokenEndpoint()
    {
        return "https://www.yammer.com/oauth/request_token";
    }

    public function getAccessTokenEndpoint()
    {
        return "https://www.yammer.com/oauth/access_token";
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return sprintf(self::AUTHORIZATION_URL, $requestToken->getToken());
    }

    public function getSignatureService()
    {
        return new PlaintextSignatureService();
    }
}