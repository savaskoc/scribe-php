<?php
namespace Hyperion\Scribe\Laravel;

use Illuminate\Support\Facades\Facade;

class BuilderFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scribe-builder';
    }
}