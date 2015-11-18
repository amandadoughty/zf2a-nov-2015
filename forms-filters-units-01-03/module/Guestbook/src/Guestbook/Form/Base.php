<?php
namespace Guestbook\Form;

use Zend\Form\Fieldset;

class Base extends Fieldset
{
    public function __construct($captchaOptions)
    {
        parent::__construct('base');
        
        $captcha = new \Zend\Form\Element\Captcha('captcha');
        $captchaAdapter = new \Zend\Captcha\Image();
        $captchaAdapter->setWordlen(4)
				        ->setOptions($captchaOptions);
        $captcha->setCaptcha($captchaAdapter)
		        ->setLabel('Help us to prevent SPAM!')
		        ->setAttribute('title', 'Help to prevent SPAM');
		$this->add($captcha);

		$this->add(array(
		    'name' => 'csrf',
		    'type' => 'Csrf',
		));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Submit'
            ),
        ));
    }
}
