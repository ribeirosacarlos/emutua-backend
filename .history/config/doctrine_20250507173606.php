<?php

return [
    'managers' => [
        'default' => [
            'dev' => env('APP_DEBUG', false),
            'meta' => 'attributes',
            'connection' => env('DB_CONNECTION', 'pgsql'),
            'namespaces' => [
                'App\\Entities'
            ],
            'paths' => [
                base_path('app/Entities')
            ],
            'repository' => Doctrine\ORM\EntityRepository::class,
            'proxies' => [
                'namespace' => 'DoctrineProxies', // ESSA LINHA É OBRIGATÓRIA!
                'path' => storage_path('proxies'),
                'auto_generate' => env('DOCTRINE_PROXY_AUTOGENERATE', true)
            ],
            'events' => [
                'listeners' => [],
                'subscribers' => []
            ],
            'filters' => [],
            'mapping_types' => []
        ]
    ],
    'extensions' => []
];