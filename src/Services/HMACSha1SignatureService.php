<?php
namespace Hyperion\Scribe\Services;

use Hyperion\Scribe\Exceptions\OAuthSignatureException;
use Hyperion\Scribe\Utils\Preconditions;
use Hyperion\Scribe\Utils\URLUtils;

class HMACSha1SignatureService implements SignatureService
{
    const HASH_ALGO = 'sha1';
    const METHOD = "HMAC-SHA1";

    public function getSignature($baseString, $apiSecret, $tokenSecret)
    {
        try {
            Preconditions::checkEmptyString($baseString, "Base string cant be null or empty string");
            Preconditions::checkEmptyString($apiSecret, "Api secret cant be null or empty string");
            return $this->doSign($baseString, URLUtils::percentEncode($apiSecret) . '&' . URLUtils::percentEncode($tokenSecret));
        } catch (\Exception $e) {
            throw new OAuthSignatureException($baseString, $e);
        }
    }

    private function doSign($toSign, $keyString)
    {
        if (function_exists('hash_hmac')) {
            $signature = base64_encode(hash_hmac(self::HASH_ALGO, $toSign, $keyString, true));
        } else {
            $blockSize = 64;
            $hashFunction = self::HASH_ALGO;
            if (strlen($keyString) > $blockSize) {
                $keyString = pack('H*', $hashFunction($keyString));
            }
            $keyString = str_pad($keyString, $blockSize, chr(0x00));
            $iPad = str_repeat(chr(0x36), $blockSize);
            $oPad = str_repeat(chr(0x5c), $blockSize);
            $hmac = pack('H*', $hashFunction(($keyString ^ $oPad) . pack('H*', $hashFunction(($keyString ^ $iPad) . $toSign))));
            $signature = base64_encode($hmac);
        }
        return $signature;
    }

    public function getSignatureMethod()
    {
        return self::METHOD;
    }
}