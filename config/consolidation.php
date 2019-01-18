<?php

return [
    'directories_to_compare' => [
        'troc/Management/resources/assets/js' => 'resources/assets/js-admin',
        'troc/Management/resources/assets/sass' => 'resources/assets/sass-admin',
        'troc/Storefront/resources/views' => 'resources/views/vendor/troc',
        'troc/Storefront/resources/assets/sass' => 'resources/assets/sass/troc-storefront',
    ],

    'output' => 'storage/consolidation',

    'url' => '/cc/consolidation',
];
