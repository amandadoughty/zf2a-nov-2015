<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonMarket for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'market-index-controller',
                        'action'     => 'index',
                    ),
                ),
            ),
            'market' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/market[/]',
                    'defaults' => array(
                        'controller' => 'market-index-controller',
                        'action'     => 'index',
                    ),
                ),
            ),
            'market-city' => array(
                'type'    => 'CityRoute',
                'options' => array(
                    'route'    => '/city',
                    'defaults' => array(
                        'controller' => 'market-view-controller',
                        'action'     => 'city',
                        'pattern'    => '!/city/(\w+| )!',
                        'cache'      => TRUE,
                    ),
                ),
            ),
            'market-city-list' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/city-list[/:alpha]',
                    'defaults' => array(
                        'controller'    => 'market-view-controller',
                        'action'        => 'city-list',
                    ),
                    'constraints' => array(
                        'alpha' => '[A-Z]{1}',    
                    ),
                ),
            ),
            'market-view' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/market/view',
                    'defaults' => array(
                        'controller' => 'market-view-controller',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route' => '[/:cat][/]',
                            'constraints' => array(
                                'cat'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'cache'      => TRUE,
                            ),
                        ),
                    ),
                ),
            ),
            'market-item' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/market/item',
                    'defaults' => array(
                        'controller' => 'market-view-controller',
                        'action'     => 'item',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:id][/]',
                            'constraints' => array(
                                'id'     => '[0-9]*',
                            ),
                            'defaults' => array(
                                'cache'      => TRUE,
                            ),
                        ),
                    ),
                ),
            ),
            'market-post' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/market/post[/]',
                    'defaults' => array(
                        'controller'    => 'market-post-controller',
                        'action'        => 'index',
                    ),
                ),
            ),
            'market-delete' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/market/delete',
                    'defaults' => array(
                        'controller'    => 'market-delete-controller',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '[/:id][/]',
                            'constraints' => array(
                                'id'     => '[0-9]*',
                            ),
                        ),
                    ),
                ),
            ),
            'market-delete-confirm' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/market/delete/confirm',
                    'defaults' => array(
                        'controller'    => 'market-delete-controller',
                        'action'        => 'deleteConfirm',
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
    	'invokables' => array(
            'post-form' 		=> 'Market\Form\PostForm',
            'post-form-filter' 	=> 'Market\Form\PostFormFilter',
            'delete-form' 		=> 'Market\Form\DeleteForm',
            'delete-form-filter'=> 'Market\Form\DeleteFormFilter',
    	),
        'factories' => array(
            'listings-table' 	=> 'Market\Factory\ListingsTableFactory',
            'city-codes-table' 	=> 'Market\Factory\CityCodesTableFactory',
            // moved to Notification module
            //'mail-transport' 	=> 'Market\Factory\MailTransportFactory',
    	),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
    	'factories' => array(
            'market-index-controller'  => 'Market\Factory\IndexControllerFactory',
            'market-view-controller'   => 'Market\Factory\ViewControllerFactory',
            'market-post-controller'   => 'Market\Factory\PostControllerFactory',
            'market-delete-controller' => 'Market\Factory\DeleteControllerFactory',
    	),
        'initializers' => array(
            // injects listings table
            'market-controller-initializer' => 'Market\Model\ListingsTableInitializer',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
