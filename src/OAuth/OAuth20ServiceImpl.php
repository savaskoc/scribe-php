<?php
namespace Hyperion\Scribe\OAuth;

use Hyperion\Scribe\Builder\Api\DefaultApi20;
use Hyperion\Scribe\Exceptions\UnsupportedOperationException;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Model\OAuthConstants;
use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verifier;

class OAuth20ServiceImpl implements OAuthService
{
    const VERSION = "2.0";
    private $api;
    private $config;

    public function __construct(DefaultApi20 $api, OAuthConfig $config)
    {
        $this->api = $api;
        $this->config = $config;
    }

    public function getAccessToken(Token $requestToken, Verifier $verifier)
    {
        $request = new OAuthRequest($this->api->getAccessTokenVerb(), $this->api->getAccessTokenEndpoint());
        $request->addQuerystringParameter(OAuthConstants::CLIENT_ID, $this->config->getApiKey());
        $request->addQuerystringParameter(OAuthConstants::CLIENT_SECRET, $this->config->getApiSecret());
        $request->addQuerystringParameter(OAuthConstants::CODE, $verifier->getValue());
        $request->addQuerystringParameter(OAuthConstants::REDIRECT_URI, $this->config->getCallback());
        if ($this->config->hasScope()) {
            $request->addQuerystringParameter(OAuthConstants::SCOPE, $this->config->getScope());
        }
        $response = $request->send();
        return $this->api->getAccessTokenExtractor()->extract($response->getBody());
    }

    public function getRequestToken()
    {
        throw new UnsupportedOperationException("Unsupported operation, please use " . "'getAuthorizationUrl' and redirect your users there");
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    public function signRequest(Token $accessToken, OAuthRequest $request)
    {
        $request->addQuerystringParameter(OAuthConstants::ACCESS_TOKEN, $accessToken->getToken());
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return $this->api->getAuthorizationUrl($this->config);
    }
}