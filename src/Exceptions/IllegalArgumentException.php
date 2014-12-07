<?php
namespace Hyperion\Scribe\Exceptions;
class IllegalArgumentException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $e = null)
    {
        parent::__construct($message, $code, $e);
    }
}