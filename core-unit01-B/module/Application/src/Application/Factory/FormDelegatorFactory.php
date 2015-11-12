<?php
namespace Application\Factory;
use Zend\ServiceManager\DelegatorFactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Form\Element\MultiCheckbox;
class FormDelegatorFactory implements DelegatorFactoryInterface
{
	public function createDelegatorWithName(ServiceLocatorInterface $sm, $name, $requestedName, $callback)
	{
		$form  = call_user_func($callback);
        $prefs = new MultiCheckbox('preferences');
        $prefs->setLabel('Preferences:')
              ->setValueOptions($sm->get('application-contact-preferences'));
        $form->add($prefs);
		return $form;
	}
}
