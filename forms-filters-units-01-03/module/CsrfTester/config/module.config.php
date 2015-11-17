<?php
return array(
    'router' => array(
        'routes' => array(
            'csrf-test' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/csrf-test',
                    'defaults' => array(
                        'controller' => 'csrftester-index',
                        'action'     => 'index',
                    ),
                ),
            ),
            'csrf-poster' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/csrf-poster',
                    'defaults' => array(
                        'controller' => 'csrftester-index',
                        'action'     => 'malicious',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'csrftester-index' => 'CsrfTester\Controller\IndexController'
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
