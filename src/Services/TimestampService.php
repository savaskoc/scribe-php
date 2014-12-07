<?php
namespace Hyperion\Scribe\Services;
interface TimestampService
{
    public function getTimestampInSeconds();

    public function getNonce();
}