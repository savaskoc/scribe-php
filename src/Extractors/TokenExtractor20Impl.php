<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Exceptions\OAuthException;
use Hyperion\Scribe\Model\Token;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class TokenExtractor20Impl implements AccessTokenExtractor
{
    const TOKEN_REGEX = "/access_token=([^&]+)/";
    const EMPTY_SECRET = "";

    public function extract($response)
    {
        Preconditions::checkEmptyString($response, "Response body is incorrect. " . "Can't extract a token from an empty string");
        if (preg_match(self::TOKEN_REGEX, $response, $matches)) {
            $token = URLUtils::formURLDecode($matches[1]);
            return new Token($token, self::EMPTY_SECRET, $response);
        } else {
            throw new OAuthException("Response body is incorrect. Can't extract a " . "token from this: '" . $response . "'", null);
        }
    }
}