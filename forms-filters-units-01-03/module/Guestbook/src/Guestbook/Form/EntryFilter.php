<?php
namespace Guestbook\Form;

use Zend\InputFilter\InputFilter;

class EntryFilter extends InputFilter
{
    public function __construct()
    {
        $this->add(array(
            'name' => 'name',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 1,
                        'max' => 255,
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array('name' => 'EmailAddress')
            ),
        ));

        $this->add(array(
            'name' => 'website',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim'),
				array('name' => 'UriNormalize', 
    		  		  'options' => array('enforcedScheme' => 'http')),
            ),
            'validators' => array(
                array('name' => 'Uri')
            ),
        ));

        $this->add(array(
            'name' => 'message',
            'required' => true,
            'filters' => array(
                array('name' => 'StringTrim')
            ),
            'validators' => array(
                array('name' => 'NotEmpty'),
            ),
        ));
    }
}
