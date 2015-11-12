<?php
// copy this file to the /config/autoload folder and override any settings as needed
return [
    'service_manager' => [
        'services' => [
            'notification-email-info' => [
                'to'	  => 'admin@company.com',
                'from'	  => 'market@company.com',
                'dir'	  => realpath(__DIR__ . '/../../data/email'),
                'subject' => 'Thanks for Posting to the Online Market!',
            ],
        ],
    ],
];