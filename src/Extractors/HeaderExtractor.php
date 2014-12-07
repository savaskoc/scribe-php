<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Model\OAuthRequest;

interface HeaderExtractor
{
    public function extract(OAuthRequest $request);
}