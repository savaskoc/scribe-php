<?php
namespace Hyperion\Scribe\Extractors;
interface AccessTokenExtractor
{
    public function extract($response);
}