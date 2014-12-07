<?php
namespace Hyperion\Scribe\Exceptions;
class OAuthException extends \Exception
{
    public function __construct($message, \Exception $e = null)
    {
        if ($e) {
            parent::__construct($message, $e->getCode(), $e);
        } else {
            parent::__construct($message, null, null);
        }
    }
}