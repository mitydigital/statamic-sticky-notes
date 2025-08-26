<?php

namespace MityDigital\StatamicStickyNotes\Widgets;

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use Statamic\Facades\Addon;
use Statamic\Widgets\Widget;

class StickyNotes extends Widget
{
    public function html()
    {
        $notes = Addon::get('mitydigital/statamic-sticky-notes')->settings();

        return view('statamic-sticky-notes::widgets.sticky-notes', [
            'icon' => StatamicStickyNotes::svg('sticky-notes'),

            'show' => (bool) $notes->get('show') ?? false,
            'heading' => $notes->get('heading') ?? __('statamic-sticky-notes::cp.name'),
            'intro' => $notes->get('intro') ?? null,
            'content' => $notes->get('content') ?? [],
        ]);
    }
}
