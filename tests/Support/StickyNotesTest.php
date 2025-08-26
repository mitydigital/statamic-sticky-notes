<?php

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;

it('can load an svg from the project', function () {
    expect(StatamicStickyNotes::svg('sticky-notes'))
        ->toBeString()
        ->not()->toBeEmpty()
        ->and(StatamicStickyNotes::svg('fake-file'))
        ->toBeString()
        ->toBeEmpty();

});

it('can create the correct blueprint', function () {
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->has('show')->toBeTrue()
        ->fields()->get('show')->type()->toBe('toggle')
        ->fields()->get('show')->get('validate')->toBe(['boolean'])
        ->fields()->has('heading')->toBeTrue()
        ->fields()->get('heading')->type()->toBe('text')
        ->fields()->get('heading')->get('validate')->toBe(['required', 'string'])
        ->fields()->has('intro')->toBeTrue()
        ->fields()->get('intro')->type()->toBe('text')
        ->fields()->get('intro')->get('validate')->toBe([])
        ->fields()->has('content')->toBeTrue()
        ->fields()->get('content')->type()->toBe('bard')
        ->fields()->get('content')->get('validate')->toBe(['required']);
});

it('can include config-defined buttons in the bard blueprint', function () {
    // null by default
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('buttons')->toBeNull();

    // set a button
    config()->set('statamic-sticky-notes.content.buttons', [
        'bold',
    ]);

    // now to have the array
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('buttons')
        ->toBeArray()
        ->toBe([
            'bold',
        ]);

    // change the buttons
    config()->set('statamic-sticky-notes.content.buttons', [
        'italic',
        'image',
    ]);

    // now to have the array
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('buttons')
        ->toBeArray()
        ->toBe([
            'italic',
            'image',
        ]);
});

it('can include config-defined container in the bard blueprint', function () {
    // null by default
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('container')->toBeNull();

    config()->set('statamic-sticky-notes.content.container', 'assets');

    // should be the container
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('container')->toBe('assets');
});

it('can include config-defined link collections in the bard blueprint', function () {
    // null by default
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')->toBeNull();

    config()->set('statamic-sticky-notes.content.link_collections', ['pages']);

    // should be the array of collections
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')
        ->toBeArray()
        ->toBe(['pages']);

    // must be an array
    config()->set('statamic-sticky-notes.content.link_collections', 'pages');

    // should be the array of collections
    $blueprint = \Statamic\Facades\Blueprint::make()->setContents(StatamicStickyNotes::blueprint());
    expect($blueprint)
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')->toBeNull();
});
