<?php

return [
    'nav' => 'Sticky Notes',

    'name' => 'Sticky Notes for Statamic',
    'permission' => [
        'label' => 'Manage Sticky Notes for Statamic',
        'description' => 'Grants access to edit Sticky Notes for Statamic.',
    ],

    'show' => [
        'display' => 'Show on Dashboard?',
        'instructions' => 'You can toggle to show (or hide) Sticky Notes on the CP Dashboard.',

        'hidden' => 'Hidden on Dashboard',
        'shown' => 'Shown on Dashboard',
    ],

    'heading' => [
        'display' => 'Heading',
        'instructions' => 'Required. Displayed at the top of the Sticky Notes Widget panel.',
    ],

    'intro' => [
        'display' => 'Introduction',
        'instructions' => 'Optional. Displayed at the top of the Sticky Notes Widget panel, beneath the Heading.',
    ],

    'content' => [
        'display' => 'Content',
        'instructions' => 'Required. The main Sticky Note content.',
    ],
];
