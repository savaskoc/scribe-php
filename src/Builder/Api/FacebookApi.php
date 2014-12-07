<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class FacebookApi extends DefaultApi20
{
    const AUTHORIZE_URL = "https://www.facebook.com/dialog/oauth?client_id=%s&redirect_uri=%s";
    const SCOPED_AUTHORIZE_URL = "https://www.facebook.com/dialog/oauth?client_id=%s&redirect_uri=%s&scope=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://graph.facebook.com/oauth/access_token";
    }

    public function getAuthorizationUrl(OAuthConfig $config)
    {
        Preconditions::checkValidUrl($config->getCallback(), "Must provide a valid url as callback. Facebook does not support OOB");
        if ($config->hasScope()) {
            return sprintf(self::SCOPED_AUTHORIZE_URL, $config->getApiKey(), URLUtils::formURLEncode($config->getCallback()), URLUtils::formURLEncode($config->getScope()));
        } else {
            return sprintf(self::AUTHORIZE_URL, $config->getApiKey(), URLUtils::formURLEncode($config->getCallback()));
        }
    }
}