<?php
namespace Hyperion\Scribe\Exceptions;
class UnsupportedOperationException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $e = null)
    {
        parent::__construct($message, $code, $e);
    }
}