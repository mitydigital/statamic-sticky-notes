<?php

namespace MityDigital\StatamicStickyNotes\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Statamic\Fields\Blueprint;

/**
 * @method static Blueprint blueprint()
 * @method static Collection load()
 * @method static string svg($name, $attrs = null)
 * @method static void save(array $payload)
 *
 * @see \MityDigital\StatamicStickyNotes\Support\StickyNotes
 */
class StatamicStickyNotes extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \MityDigital\StatamicStickyNotes\Support\StickyNotes::class;
    }
}
