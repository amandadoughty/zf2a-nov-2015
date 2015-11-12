<?php
/**
 * In this file you will be overriding "PhlyContact" settings
 * for the "ContactControllerFactory" and redirecting 2 view templates
 */

return array(
    'controllers' => array(
    	'factories' => array(
    		/**
    		 * Enter a key to override the "PhlyContact" controller factory
    		 */
    	),
    ),
	'view_manager' => array(
		'template_map' => array(
			/**
			 * Add 2 entries to redirect the "index" and "thank-you" view templates
			 */
		),
	),
);
