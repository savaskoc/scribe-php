<?php
namespace Hyperion\Scribe\Extractors;
interface RequestTokenExtractor
{
    public function extract($response);
}