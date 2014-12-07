<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Extractors\BaseStringExtractorImpl;
use Hyperion\Scribe\Extractors\HeaderExtractorImpl;
use Hyperion\Scribe\Extractors\TokenExtractorImpl;
use Hyperion\Scribe\Model\OAuthConfig;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Model\Verb;
use Hyperion\Scribe\OAuth\OAuth10aServiceImpl;
use Hyperion\Scribe\Services\HMACSha1SignatureService;
use Hyperion\Scribe\Services\TimestampServiceImpl;

abstract class DefaultApi10a implements Api
{
    function getAccessTokenExtractor()
    {
        return new TokenExtractorImpl();
    }

    public function getBaseStringExtractor()
    {
        return new BaseStringExtractorImpl();
    }

    public function getHeaderExtractor()
    {
        return new HeaderExtractorImpl();
    }

    public function getRequestTokenExtractor()
    {
        return new TokenExtractorImpl();
    }

    public function getSignatureService()
    {
        return new HMACSha1SignatureService();
    }

    public function getTimestampService()
    {
        return new TimestampServiceImpl();
    }

    public function getAccessTokenVerb()
    {
        return Verb::POST;
    }

    public function getRequestTokenVerb()
    {
        return Verb::POST;
    }

    public abstract function getRequestTokenEndpoint();

    public abstract function getAccessTokenEndpoint();

    public abstract function getAuthorizationUrl(Token $requestToken);

    public function createService(OAuthConfig $config)
    {
        return new OAuth10aServiceImpl($this, $config);
    }
}