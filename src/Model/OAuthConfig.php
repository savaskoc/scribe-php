<?php
namespace Hyperion\Scribe\Model;
class OAuthConfig
{
    private $apiKey;
    private $apiSecret;
    private $callback;
    private $signatureType;
    private $scope;

    public function __construct($key, $secret, $callback = null, $type = null, $scope = null)
    {
        $this->apiKey = $key;
        $this->apiSecret = $secret;
        $this->callback = $callback;
        $this->signatureType = $type;
        $this->scope = $scope;
    }

    public function getApiKey()
    {
        return $this->apiKey;
    }

    public function getApiSecret()
    {
        return $this->apiSecret;
    }

    public function getCallback()
    {
        return $this->callback;
    }

    public function getSignatureType()
    {
        return $this->signatureType;
    }

    public function getScope()
    {
        return $this->scope;
    }

    public function hasScope()
    {
        return $this->scope != null;
    }
}