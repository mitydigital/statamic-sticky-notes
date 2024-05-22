<?php

use MityDigital\StatamicStickyNotes\Facades\StatamicStickyNotes;
use MityDigital\StatamicStickyNotes\Widgets\StickyNotes;

beforeEach(function () {
    $this->widget = new StickyNotes();
});

it('returns the correct view', function () {
    expect($this->widget->html())
        ->toBeInstanceOf(\Illuminate\View\View::class);
});

it('has data with the correct keys', function () {
    expect($this->widget->html())
        ->getData()->toHaveKeys([
            'icon', 'show', 'heading', 'intro', 'content',
        ]);
});

it('correctly includes the sticky notes icon', function () {
    expect($this->widget->html()->getData()['icon'])
        ->toBeString()
        ->toBe(StatamicStickyNotes::svg('sticky-notes'));
});

it('correctly includes a boolean value for show', function () {
    // by default, will be false
    expect($this->widget->html()->getData()['show'])
        ->toBeBool()
        ->toBeFalse();

    // update configuration
    enableStickyNoteContent();

    // try again, and should be true
    expect($this->widget->html()->getData()['show'])
        ->toBeBool()
        ->toBeTrue();
});

it('has the correct heading', function () {
    // by default, will be a language string
    expect($this->widget->html()->getData()['heading'])
        ->toBeString()
        ->toBe(__('statamic-sticky-notes::cp.name'));

    // update configuration
    enableStickyNoteContent();

    // try again, and should be the stored string
    expect($this->widget->html()->getData()['heading'])
        ->toBeString()
        ->toBe('This is a custom heading');
});

it('has the correct intro', function () {
    // by default, will be a language string
    expect($this->widget->html()->getData()['intro'])
        ->toBeNull();

    // update configuration
    enableStickyNoteContent();

    // try again, and should be the stored string
    expect($this->widget->html()->getData()['intro'])
        ->toBeString()
        ->toBe('And a custom introduction');
});

it('has the correct content', function () {
    // by default, will be a language string
    expect($this->widget->html()->getData()['content'])
        ->toBeArray()
        ->toHaveCount(0);

    // update configuration
    enableStickyNoteContent();

    // try again, and should be the stored string
    expect($this->widget->html()->getData()['content'])
        ->toBeArray()
        ->toHaveCount(2)
        ->and(\Statamic\Statamic::modify($this->widget->html()->getData()['content'])->bardHtml()->__toString())
        ->toBeString()
        ->toBe('<p>Bard content</p><p>With two lines</p>');
});
