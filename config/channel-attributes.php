<?php

return [
    /*
     *  Automatic registration of channels will only happen if this setting is `true`
     */
    'enabled' => true,

    /*
     * Channels in these directories that have channel attributes will automatically be registered. You can specify a
     * different namespace other than `\App` by providing a different key.
     *
     * e.g ['\Domain\Post\Broadcasting' => base_path('domain/Post/Broadcasting')]
     */
    'directories' => [
        app_path('Broadcasting'),
    ],
];
