<?php
namespace Hyperion\Scribe\Extractors;

use Hyperion\Scribe\Model\OAuthRequest;

interface BaseStringExtractor
{
    public function extract(OAuthRequest $request);
}