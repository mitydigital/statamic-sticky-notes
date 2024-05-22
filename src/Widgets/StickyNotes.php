<?php

namespace MityDigital\StatamicStickyNotes\Widgets;

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use Statamic\Widgets\Widget;

class StickyNotes extends Widget
{
    public function html()
    {
        $notes = StatamicStickyNotes::load();

        return view('statamic-sticky-notes::widgets.sticky-notes', [
            'icon' => StatamicStickyNotes::svg('sticky-notes'),

            'show' => $notes['show'] ?? false,
            'heading' => $notes['heading'] ?? __('statamic-sticky-notes::cp.name'),
            'intro' => $notes['intro'] ?? null,
            'content' => $notes['content'] ?? [],
        ]);
    }
}
