<?php

use MityDigital\StatamicStickyNotes\Http\CP\Controllers\StatamicStickyNotesController;

Route::get('sticky-notes', [StatamicStickyNotesController::class, 'show'])
    ->name('statamic-sticky-notes.show');

Route::post('sticky-notes', [StatamicStickyNotesController::class, 'update'])
    ->name('statamic-sticky-notes.update');
