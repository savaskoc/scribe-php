<?php
namespace Hyperion\Scribe\Exceptions;
class OAuthSignatureException extends OAuthException
{
    public function __construct($stringToSign, \Exception $e)
    {
        parent::__construct("Error while signing string: " + $stringToSign, $e);
    }
}