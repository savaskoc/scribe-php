<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\OAuthConfig;

class GoogleApi extends DefaultApi20
{
    const AUTHORIZATION_URL = "https://accounts.google.com/o/oauth2/auth?access_type=offline&scope=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://accounts.google.com/o/oauth2/token";
    }

    public function getAuthorizationUrl(OAuthConfig $config)
    {
        return sprintf(self::AUTHORIZATION_URL, $config->getScope());
    }
}