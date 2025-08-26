<?php

namespace MityDigital\StatamicStickyNotes;

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use MityDigital\StatamicStickyNotes\Widgets\StickyNotes;
use Statamic\Facades\YAML;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $updateScripts = [
        \MityDigital\StatamicStickyNotes\UpdateScripts\v2_0_0\CreateSettings::class,
    ];

    protected $vite = [
        'input' => [
            'resources/css/statamic-sticky-notes.css',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    protected $widgets = [
        StickyNotes::class,
    ];

    public function bootAddon()
    {

        if (false) {
            dd(YAML::dump());
        }
        $this->registerSettingsBlueprint(StatamicStickyNotes::blueprint());

        $this->app->bind('StatamicStickyNotes', function () {
            return new \MityDigital\StatamicStickyNotes\Support\StickyNotes;
        });
    }
}
