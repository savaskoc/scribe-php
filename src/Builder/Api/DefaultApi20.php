<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Extractors\TokenExtractor20Impl;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Model\Verb;
use Hyperion\Scribe\OAuth\OAuth20ServiceImpl;

abstract class DefaultApi20 implements Api
{
    public function getAccessTokenExtractor()
    {
        return new TokenExtractor20Impl();
    }

    public function getAccessTokenVerb()
    {
        return Verb::GET;
    }

    public abstract function getAccessTokenEndpoint();

    public abstract function getAuthorizationUrl(OAuthConfig $config);

    public function createService(OAuthConfig $config)
    {
        return new OAuth20ServiceImpl($this, $config);
    }
}