<?php
namespace Hyperion\Scribe\Services;

use Hyperion\Scribe\Exceptions\OAuthSignatureException;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class PlaintextSignatureService implements SignatureService
{
    const METHOD = "plaintext";

    public function getSignature($baseString, $apiSecret, $tokenSecret)
    {
        try {
            Preconditions::checkEmptyString($apiSecret, "Api secret cant be null or empty string");
            return URLUtils::percentEncode($apiSecret) . '&' . URLUtils::percentEncode($tokenSecret);
        } catch (\Exception $e) {
            throw new OAuthSignatureException($baseString, $e);
        }
    }

    public function getSignatureMethod()
    {
        return self::METHOD;
    }
}