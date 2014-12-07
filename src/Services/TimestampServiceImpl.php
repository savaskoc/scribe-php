<?php
namespace Hyperion\Scribe\Services;
class TimestampServiceImpl implements TimestampService
{
    private $timer;

    public function __construct()
    {
        $this->timer = new Timer();
    }

    public function getNonce()
    {
        $ts = $this->timer->getTs();
        return (string)$ts + $this->timer->getRandomInteger();
    }

    public function getTimestampInSeconds()
    {
        return (string)$this->timer->getTs();
    }

    public function setTimer(Timer $timer)
    {
        $this->timer = $timer;
    }
}

class Timer
{
    public function getTs()
    {
        return time();
    }

    public function getRandomInteger()
    {
        return mt_rand();
    }
}