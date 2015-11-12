<?php
/**
 * This is a sample "local" configuration for your application. To use it, copy 
 * it to your config/autoload/ directory of your application, and edit to suit
 * your application.
 *
 * This configuration example demonstrates using an SMTP mail transport, an
 * Image CAPTCHA adapter, and setting the to and sender addresses for the
 * mail message.
 * 
 * NOTE: assumes font is /data/fonts/FreeSansBold.ttf and that the CAPTCHA
 *       images will be written to /public/captcha
 */
return array(
    'phly_contact' => array(
        // This is simply configuration to pass to Zend\Captcha\Factory
        'captcha' => array(
            'class'   => 'image',
            'options' => array(
            	'dotNoiseLevel' => 100,
            	'expiration' 	=> 300,
            	'font'			=> __DIR__ . '/../../data/fonts/FreeSansBold.ttf',
            	'fontSize' 		=> 30,
            	'height' 		=> 50,
            	'imgAlt' 		=> 'Some Image',
            	'imgDir' 		=> __DIR__ . '/../../public/captcha',
            	'imgUrl' 		=> '/captcha',
            	'lineNoiseLevel'=> 4,
            	'timeout' 		=> 300,
            	'width' 		=> 150,
            	'wordLen' 		=> 4,
            ),
        ),

        // This sets the default "to" and "sender" headers for your message
        'message' => array(
            // These can be either a string, or an array of email => name pairs
            'to'     => 'contact@unlikelysource.com',
            'from'   => 'contact@unlikelysource.com',
            // This should be an array with minimally an "address" element, and 
            // can also contain a "name" element
            'sender' => array(
                'address' => 'contact@unlikelysource.com'
            ),
        ),

        // Transport consists of two keys: 
        // - "class", the mail tranport class to use, and
        // - "options", any options to use to configure the 
        //   tranpsort. Usually these will be passed to the 
        //   transport-specific options class
        // This example configures GMail as your SMTP server
        /*
        'mail_transport' => array(
            'class'   => 'Zend\Mail\Transport\Smtp',
            'options' => array(
                'host'             => 'smtp.gmail.com',
                'port'             => 587,
                'connectionClass'  => 'login',
                'connectionConfig' => array(
                    'ssl'      => 'tls',
                    'username' => 'contact@your.tld',
                    'password' => 'password',
                ),
            ),
        ),
        */
        // This example configures a File mail transport
        // NOTE: make sure the path is writable by the application
        'mail_transport' => array(
            'class'   => 'Zend\Mail\Transport\File',
            'options' => array(
            	'path' => realpath(__DIR__ . '/../../data/messages'),
            ),
        ),
    ),
);
