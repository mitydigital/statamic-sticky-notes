<?php

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;

it('gets the path from the config', function () {
    expect(StatamicStickyNotes::getPath())
        ->toBe(base_path('content').'/statamic-sticky-notes.yaml');

    // update the configured path
    config()->set('statamic-sticky-notes.path', __DIR__.'/__fixtures__/content');

    expect(StatamicStickyNotes::getPath())
        ->toBe(__DIR__.'/__fixtures__/content/statamic-sticky-notes.yaml');
});

it('gets the filename from the config', function () {
    expect(StatamicStickyNotes::getPath())
        ->toBe(base_path('content').'/statamic-sticky-notes.yaml');

    // update the configured filename
    config()->set('statamic-sticky-notes.filename', 'a-custom-name');

    expect(StatamicStickyNotes::getPath())
        ->toBe(base_path('content').'/a-custom-name.yaml');
});

it('loads the saved content', function () {
    // should be empty
    expect(StatamicStickyNotes::load())
        ->toBeArray()
        ->toHaveCount(0);

    // enable loading
    enableStickyNoteContent();

    $loaded = StatamicStickyNotes::load();
    expect($loaded)
        ->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys([
            'show',
            'heading',
            'intro',
            'content',
        ])
        ->and($loaded['show'])->toBeBool()->toBeTrue()
        ->and($loaded['heading'])->toBeString()->toBe('This is a custom heading')
        ->and($loaded['intro'])->toBeString()->toBe('And a custom introduction')
        ->and($loaded['content'])->toBeArray()->toHaveCount(2)
        ->and(\Statamic\Statamic::modify($loaded['content'])->bardHtml()->__toString())
        ->toBeString()
        ->toBe('<p>Bard content</p><p>With two lines</p>');
});

it('saves the content', function () {
    // should have nothing
    expect(StatamicStickyNotes::load())
        ->toBeArray()
        ->toHaveCount(0);

    StatamicStickyNotes::save([
        'show' => true,
        'heading' => 'This is my heading',
        'intro' => 'This is my introduction',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [[
                    'type' => 'text',
                    'text' => 'This is my content.',
                ]],
            ],
        ],
    ]);

    $loaded = StatamicStickyNotes::load();
    expect($loaded)
        ->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys([
            'show',
            'heading',
            'intro',
            'content',
        ])
        ->and($loaded['show'])->toBeBool()->toBeTrue()
        ->and($loaded['heading'])->toBeString()->toBe('This is my heading')
        ->and($loaded['intro'])->toBeString()->toBe('This is my introduction')
        ->and($loaded['content'])->toBeArray()->toHaveCount(1)
        ->and(\Statamic\Statamic::modify($loaded['content'])->bardHtml()->__toString())
        ->toBeString()
        ->toBe('<p>This is my content.</p>');

    StatamicStickyNotes::save([
        'show' => false,
        'heading' => 'This is my changed heading',
        'intro' => 'This is my changed introduction',
        'content' => [
            [
                'type' => 'paragraph',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'This is my changed content.',
                    ],
                ],
            ],
            [
                'type' => 'paragraph',
                'content' => [
                    [
                        'type' => 'text',
                        'text' => 'With a new paragraph.',
                    ],
                ],
            ],
        ],
    ]);

    $loaded = StatamicStickyNotes::load();
    expect($loaded)
        ->toBeArray()
        ->toHaveCount(4)
        ->toHaveKeys([
            'show',
            'heading',
            'intro',
            'content',
        ])
        ->and($loaded['show'])->toBeBool()->toBeFalse()
        ->and($loaded['heading'])->toBeString()->toBe('This is my changed heading')
        ->and($loaded['intro'])->toBeString()->toBe('This is my changed introduction')
        ->and($loaded['content'])->toBeArray()->toHaveCount(2)
        ->and(\Statamic\Statamic::modify($loaded['content'])->bardHtml()->__toString())
        ->toBeString()
        ->toBe('<p>This is my changed content.</p><p>With a new paragraph.</p>');
});

it('can load an svg from the project', function () {
    expect(StatamicStickyNotes::svg('sticky-notes'))
        ->toBeString()
        ->not()->toBeEmpty()
        ->and(StatamicStickyNotes::svg('fake-file'))
        ->toBeString()
        ->toBeEmpty();

});

it('can create the correct blueprint', function () {
    expect(StatamicStickyNotes::blueprint())
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
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('buttons')->toBeNull();

    // set a button
    config()->set('statamic-sticky-notes.content.buttons', [
        'bold',
    ]);

    // now to have the array
    expect(StatamicStickyNotes::blueprint())
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
    expect(StatamicStickyNotes::blueprint())
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
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('container')->toBeNull();

    config()->set('statamic-sticky-notes.content.container', 'assets');

    // should be the container
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('container')->toBe('assets');
});

it('can include config-defined link collections in the bard blueprint', function () {
    // null by default
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')->toBeNull();

    config()->set('statamic-sticky-notes.content.link_collections', ['pages']);

    // should be the array of collections
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')
        ->toBeArray()
        ->toBe(['pages']);

    // must be an array
    config()->set('statamic-sticky-notes.content.link_collections', 'pages');

    // should be the array of collections
    expect(StatamicStickyNotes::blueprint())
        ->toBeInstanceOf(\Statamic\Fields\Blueprint::class)
        ->fields()->get('content')->get('link_collections')->toBeNull();
});
