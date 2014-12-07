<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Exceptions\OAuthException;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Utils\Preconditions;

class JsonTokenExtractor implements AccessTokenExtractor
{
    private $accessTokenPattern = "/\"access_token\":\"(\\S*?)\"/";

    public function extract($response)
    {
        Preconditions::checkEmptyString($response, "Cannot extract a token from a null or empty String");
        if (preg_match($this->accessTokenPattern, $response, $matches)) {
            return new Token($matches[1], "", $response);
        } else {
            throw new OAuthException("Cannot extract an acces token. Response was: " . $response);
        }
    }
}