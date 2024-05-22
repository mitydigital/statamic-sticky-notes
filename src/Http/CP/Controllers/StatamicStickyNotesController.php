<?php

namespace MityDigital\StatamicStickyNotes\Http\CP\Controllers;

use Illuminate\Http\Request;
use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use Statamic\Fields\Blueprint;
use Statamic\Http\Controllers\Controller;

class StatamicStickyNotesController extends Controller
{
    protected Blueprint $blueprint;

    public function __construct()
    {
        $this->blueprint = StatamicStickyNotes::blueprint();
    }

    public function show(Request $request)
    {
        $this->authorize('edit sticky notes for statamic');

        // get the fields
        $fields = $this->blueprint
            ->fields()
            ->addValues(StatamicStickyNotes::load())
            ->preProcess();

        // render the view
        return view('statamic-sticky-notes::show', [
            'title' => __('statamic-sticky-notes::cp.name'),
            'action' => cp_route('statamic-sticky-notes.update'),
            'blueprint' => $this->blueprint->toPublishArray(),
            'meta' => $fields->meta(),
            'values' => $fields->values(),
        ]);
    }

    public function update(Request $request)
    {
        // for the blueprint fields, add the request values
        $fields = $this->blueprint
            ->fields()
            ->addValues($request->only([
                'show',
                'heading',
                'intro',
                'content',
            ]));

        // validate
        $fields->validate();

        // save
        StatamicStickyNotes::save($fields->values()->toArray());
    }
}
