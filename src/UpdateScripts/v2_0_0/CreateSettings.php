<?php

namespace MityDigital\StatamicStickyNotes\UpdateScripts\v2_0_0;

use Illuminate\Support\Facades\File;
use Statamic\UpdateScripts\UpdateScript;

class CreateSettings extends UpdateScript
{
    public function shouldUpdate($newVersion, $oldVersion)
    {
        return $this->isUpdatingTo('2.0.0');
    }

    public function update()
    {
        if (File::exists(base_path('content/statamic-sticky-notes.yaml'))) {
            File::ensureDirectoryExists(resource_path('addons'));
            File::move(
                base_path('content/statamic-sticky-notes.yaml'),
                resource_path('addons/statamic-sticky-notes.yaml'),
            );
        }
    }
}
