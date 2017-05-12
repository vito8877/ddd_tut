<?php

return [
    'language' => 'en_US',
    'components' => [
        'db' => [
            'dsn' => 'sqlite:' . __DIR__ . '/../../data/test.db',
        ],
        'mailer' => [
            'useFileTransport' => true,
        ],
        'urlManager' => [
            'showScriptName' => true,
        ],
    ],
];