<?php
namespace Hyperion\Scribe\Model;

use Hyperion\Scribe\Utils\Preconditions;

class Verifier
{
    private $value;

    public function __construct($value)
    {
        Preconditions::checkNotNull($value, "Must provide a valid string as verifier");
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}