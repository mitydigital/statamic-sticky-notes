<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Content configuration
    |--------------------------------------------------------------------------
    |
    | The main configuration is a Bard field, and may need some additional
    | configuration based on what buttons you want to use.
    |
    */

    'content' => [

        /*
        |--------------------------------------------------------------------------
        | Buttons
        |--------------------------------------------------------------------------
        |
        | An array of buttons to appear in the Bard field. This is ordered, so
        | buttons will appear in the order you place them in your array.
        | For example:
        |
        | 'buttons' => [
        |     'bold',
        |     'italic',
        |     'unorderedlist',
        |     'orderedlist',
        | ],
        |
        | Set to 'null' to use the default Bard configuration.
        |
        | See "buttons" on https://statamic.dev/fieldtypes/bard#options
        |
        */

        'buttons' => null,

        /*
        |--------------------------------------------------------------------------
        | Container
        |--------------------------------------------------------------------------
        |
        | Required if using the 'image' button.
        |
        | The handle of the Asset container to use for the Image button. If not
        | present, the 'image' button will not show. For example:
        |
        | 'container' => 'assets',
        |
        | Set to 'null' to not define a container.
        |
        */

        'container' => null,

        /*
        |--------------------------------------------------------------------------
        | Link Collections
        |--------------------------------------------------------------------------
        |
        | Optional for the 'anchor' button.
        |
        | Limits the Collections that appear in the Entry browser when adding a
        | link to an Entry. Should be an array of Collection handles, for example:
        |
        | 'link_collections' => [
        |     'pages',
        |     'blog',
        | ],
        |
        | Set to 'null' to not define link collections.
        |
        */

        'link_collections' => null,
    ],

];
