<?php
return array(
    'router' => array(
        'routes' => array(
            'guestbook' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/guestbook',
                    'defaults' => array(
                        'controller' => 'guestbook-index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'guestbook-index' => 'Guestbook\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    'view_helpers' => array(
        'invokables' => array(
            'htmlTableRow' => 'Guestbook\Service\HtmlTableRowHelper',
        ),
    ),
    'service_manager' => array(
        'aliases' => array(
            'guestbook_zend_db_adapter' => 'Zend\Db\Adapter\Adapter',
        ),
    ),
);
