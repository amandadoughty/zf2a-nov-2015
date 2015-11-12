<?php
/**
 * In this file you will be overriding "PhlyContact" settings
 * for the "ContactControllerFactory" and redirecting 2 view templates
 */

return array(
    'service_manager' => array(
        'services' => array(
            'application-contact-preferences' => 
                array(
                    'EMAIL'  => 'Email Subscription',
                    'OFFERS' => 'Special Offers',
                    'EVENTS' => 'Special Events',
                ),
        ),
        'invokables' => array(
            'application-delegator-form-factory' => 'Application\Factory\FormDelegatorFactory',
        ),
        'delegators' => array(
            'PhlyContactForm'  => array('application-delegator-form-factory'),
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'PhlyContact\Controller\Contact' => 'Application\Factory\ContactControllerFactory',
        ),
    ),
	'view_manager' => array(
		'template_map' => array(
            //'application/contact/index' => __DIR__ . '/../../vendor/PhlyContact/view/phly-contact/contact/index.phtml',
            'application/contact/index' => __DIR__ . '/../../module/Application/view/application/contact/index.phtml',
		    'application/contact/thank-you' => __DIR__ . '/../../vendor/PhlyContact/view/phly-contact/contact/thank-you.phtml',
		),
	),
);
