<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Exceptions\OAuthException;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class TokenExtractorImpl implements RequestTokenExtractor
{
    const TOKEN_REGEX = "/oauth_token=([^&]+)/";
    const SECRET_REGEX = "/oauth_token_secret=([^&]+)/";

    public function extract($response)
    {
        Preconditions::checkEmptyString($response, "Response body is incorrect. " . "Can't extract a token from an empty string");
        $token = $this->_extract($response, self::TOKEN_REGEX);
        $secret = $this->_extract($response, self::SECRET_REGEX);
        return new Token($token, $secret, $response);
    }

    private function _extract($response, $p)
    {
        if (preg_match($p, $response, $matches) && count($matches) >= 1) {
            return URLUtils::formURLDecode($matches[1]);
        } else {
            throw new OAuthException("Response body is incorrect. Can't extract token" . " and secret from this: '" . $response . "'", null);
        }
    }
}