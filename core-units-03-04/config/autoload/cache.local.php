<?php
return array(
    'cache' => array (
   		'adapter' => array(
			'name' => 'filesystem',
    			'options' => array (
    				'cache_dir' => 'data/cache/',
    			)
   		),
   		'plugins' => array(
		// Don't throw exceptions on cache errors
			'exception_handler' => array(
				'throw_exceptions' => false
			),
			'serializer' => array (
			    'serializer' => 'Zend\Serializer\Adapter\PhpSerialize',
			)
   		)
    ),
);
