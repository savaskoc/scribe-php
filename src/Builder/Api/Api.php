<?php
namespace Hyperion\Scribe\Builder\Api;

use Hyperion\Scribe\Model\OAuthConfig;

interface Api
{
    public function createService(OAuthConfig $config);
}