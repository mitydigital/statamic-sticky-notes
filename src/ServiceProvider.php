<?php

namespace MityDigital\StatamicStickyNotes;

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use MityDigital\StatamicStickyNotes\Widgets\StickyNotes;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
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
        $this->app->bind('StatamicStickyNotes', function () {
            return new \MityDigital\StatamicStickyNotes\Support\StickyNotes();
        });

        Nav::extend(function ($nav) {
            $nav->tools(__('statamic-sticky-notes::cp.nav'))
                ->route('statamic-sticky-notes.show')
                ->icon(StatamicStickyNotes::svg('sticky-notes'))
                ->can('edit sticky notes for statamic');
        });

        // register permission
        Permission::register('edit sticky notes for statamic')
            ->label(__('statamic-sticky-notes::cp.permission.label'))
            ->description(__('statamic-sticky-notes::cp.permission.description'));
    }
}
