<?php
namespace Hyperion\Scribe\OAuth;

use Hyperion\Scribe\Builder\Api\DefaultApi10a;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Model\OAuthConstants;
use Hyperion\Scribe\Model\OAuthRequest;
use Hyperion\Scribe\Model\SignatureType;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verifier;

class OAuth10aServiceImpl implements OAuthService
{
    const VERSION = "1.0";
    private $config;
    private $api;

    public function __construct(DefaultApi10a $api, OAuthConfig $config)
    {
        $this->api = $api;
        $this->config = $config;
    }

    public function getRequestToken()
    {
        $request = new OAuthRequest($this->api->getRequestTokenVerb(), $this->api->getRequestTokenEndpoint());
        $request->addOAuthParameter(OAuthConstants::CALLBACK, $this->config->getCallback());
        $this->addOAuthParams($request, OAuthConstants::getEmptyToken());
        $this->addSignature($request);
        $response = $request->send();
        return $this->api->getRequestTokenExtractor() ->extract($response->getBody());
    }

    private function addOAuthParams(OAuthRequest $request, Token $token)
    {
        $request->addOAuthParameter(OAuthConstants::TIMESTAMP, $this->api->getTimestampService()->getTimestampInSeconds());
        $request->addOAuthParameter(OAuthConstants::NONCE, $this->api->getTimestampService()->getNonce());
        $request->addOAuthParameter(OAuthConstants::CONSUMER_KEY, $this->config->getApiKey());
        $request->addOAuthParameter(OAuthConstants::SIGN_METHOD, $this->api->getSignatureService()->getSignatureMethod());
        $request->addOAuthParameter(OAuthConstants::VERSION, $this->getVersion());
        if ($this->config->hasScope()) {
            $request->addOAuthParameter(OAuthConstants::SCOPE, $this->config->getScope());
        }
        $request->addOAuthParameter(OAuthConstants::SIGNATURE, $this->getSignature($request, $token));
    }

    public function getVersion()
    {
        return self::VERSION;
    }

    private function getSignature(OAuthRequest $request, Token $token)
    {
        $baseString = $this->api->getBaseStringExtractor()->extract($request);
        return $this->api->getSignatureService() ->getSignature($baseString, $this->config->getApiSecret(), $token->getSecret());
    }

    private function addSignature(OAuthRequest $request)
    {
        $signatureType = $this->config->getSignatureType();
        switch ($signatureType) {
            case SignatureType::HEADER:
                $oauthHeader = $this->api->getHeaderExtractor()->extract($request);
                $request->addHeader(OAuthConstants::HEADER, $oauthHeader);
                break;
            case SignatureType::QUERY_STRING:
                $oauthParams = $request->getOauthParameters();
                foreach ($oauthParams as $key => $val) {
                    $request->addQuerystringParameter($key, $val);
                }
                break;
        }
    }

    public function getAccessToken(Token $requestToken, Verifier $verifier)
    {
        $request = new OAuthRequest($this->api->getAccessTokenVerb(), $this->api->getAccessTokenEndpoint());
        $request->addOAuthParameter(OAuthConstants::TOKEN, $requestToken->getToken());
        $request->addOAuthParameter(OAuthConstants::VERIFIER, $verifier->getValue());
        $this->addOAuthParams($request, $requestToken);
        $this->addSignature($request);
        $response = $request->send();
        return $this->api->getAccessTokenExtractor()->extract($response->getBody());
    }

    public function signRequest(Token $token, OAuthRequest $request)
    {
        $request->addOAuthParameter(OAuthConstants::TOKEN, $token->getToken());
        $this->addOAuthParams($request, $token);
        $this->addSignature($request);
    }

    public function getAuthorizationUrl(Token $requestToken)
    {
        return $this->api->getAuthorizationUrl($requestToken);
    }
}