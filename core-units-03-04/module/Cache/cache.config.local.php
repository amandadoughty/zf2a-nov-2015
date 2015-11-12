<?php
// copy this file to the /config/autoload folder and override any settings as needed
return [
    'service_manager' => [
        'services' => [
            'cache-config' => [
                'adapter' => [
                    'name'      => 'filesystem',
                    'options'   => ['ttl' => 3600,
                        'cache_dir' => __DIR__ . '/../../data/cache'],
                ],
                'plugins' => [
                    // override this on production server to FALSE
                    'exception_handler' => ['throw_exceptions' => TRUE],
                ],
            ],
        ],
    ],
];