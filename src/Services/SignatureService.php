<?php
namespace Hyperion\Scribe\Services;
interface SignatureService
{
    public function getSignature($baseString, $apiSecret, $tokenSecret);

    public function getSignatureMethod();
}