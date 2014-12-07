<?php
namespace Hyperion\Scribe\Model;
class OAuthRequest extends Request
{
    const OAUTH_PREFIX = "oauth_";
    private $oauthParameters = array();

    public function __construct($verb, $url)
    {
        parent::__construct($verb, $url);
        $this->oauthParameters = array();
    }

    public function addOAuthParameter($key, $value)
    {
        $this->oauthParameters[$this->checkKey($key)] = $value;
    }

    private function checkKey($key)
    {
        if (strpos($key, self::OAUTH_PREFIX) === 0 || $key === OAuthConstants::SCOPE) {
            return $key;
        } else {
            throw new \Exception(sprintf("OAuth parameters must either be '%s' or " . "start with '%s'", OAuthConstants::SCOPE, self::OAUTH_PREFIX));
        }
    }

    public function getOauthParameters()
    {
        return $this->oauthParameters;
    }

    public function __toString()
    {
        return sprintf("@OAuthRequest(%s, %s)", $this->getVerb(), $this->getUrl());
    }
}