<?php

return [

    'default' => 'notyf',

    'main_script' => '/vendor/flasher/flasher.min.js',

    'public_path' => '',

    'styles' => [
        '/vendor/flasher/flasher.min.css',
    ],

    'inject_assets' => true,

    'translate' => true,

    'excluded_paths' => [],

    'flash_bag' => [
        'success' => ['success'],
        'error' => ['error', 'danger'],
        'warning' => ['warning', 'alarm'],
        'info' => ['info', 'notice', 'alert'],
    ],

];
