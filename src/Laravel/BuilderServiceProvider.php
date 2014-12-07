<?php
namespace Hyperion\Scribe\Laravel;

use Illuminate\Support\ServiceProvider;

class BuilderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('scribe-builder', function () {
            return new Builder;
        });
    }
}