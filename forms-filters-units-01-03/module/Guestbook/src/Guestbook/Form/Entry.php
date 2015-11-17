<?php
namespace Guestbook\Form;

use Zend\Form\Form;

class Entry extends Form
{
    public function __construct($captchaOptions)
    {
        parent::__construct();

        $this->add(array(
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
            'attributes' => array(
                'type' => 'email'
            ),
        ));

        $this->add(array(
            'name' => 'website',
            'options' => array(
                'label' => 'Website',
            ),
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'message',
            'options' => array(
                'label' => 'Message',
            ),
            'attributes' => array(
                'type' => 'textarea'
            ),
        ));

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
