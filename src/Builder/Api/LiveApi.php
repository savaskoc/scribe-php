<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Extractors\JsonTokenExtractor;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class LiveApi extends DefaultApi20
{
    const AUTHORIZE_URL = "https://oauth.live.com/authorize?client_id=%s&redirect_uri=%s&response_type=code";
    const SCOPED_AUTHORIZE_URL = "https://oauth.live.com/authorize?client_id=%s&redirect_uri=%s&response_type=code&scope=%s";

    public function getAccessTokenEndpoint()
    {
        return "https://oauth.live.com/token?grant_type=authorization_code";
    }

    public function getAuthorizationUrl(OAuthConfig $config)
    {
        Preconditions::checkValidUrl($config->getCallback(), "Must provide a valid url as callback. Live does not support OOB");
        if ($config->hasScope()) {
            return sprintf(self::SCOPED_AUTHORIZE_URL, $config->getApiKey(), URLUtils::formURLEncode($config->getCallback()), URLUtils::formURLEncode($config->getScope()));
        } else {
            return sprintf(self::AUTHORIZE_URL, $config->getApiKey(), URLUtils::formURLEncode($config->getCallback()));
        }
    }

    public function getAccessTokenExtractor()
    {
        return new JsonTokenExtractor();
    }
}