<?php
namespace Guestbook;

use Application\Service\AppService;
use Guestbook\Form\Base;
use Zend\ModuleManager\ModuleManager;
use Zend\EventManager\EventInterface;
use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;

class Module implements
    AutoloaderProviderInterface,
    ConfigProviderInterface,
    ServiceProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'guestbook_entry_service' => 'Guestbook\Service\Entry',
                'guestbook_entry_filter' => 'Guestbook\Form\EntryFilter',
                'guestbook_entry_hydrator' => 'Guestbook\Mapper\EntryHydrator',
                'guestbook_entity_entry' => 'Guestbook\Entity\Entry',
            ),
            'factories' => array(
                'guestbook_entry_mapper' => function ($sm) {
                    $mapper = new Mapper\Entry();
                    $mapper->setDbAdapter($sm->get('guestbook_zend_db_adapter'));
                    $mapper->setHydrator($sm->get('guestbook_entry_hydrator'));
                    $mapper->setEntityPrototype($sm->get('guestbook_entity_entry'));
                    return $mapper;
                },
                /*
                'guestbook_entry_form' => function ($sm) {
                    $form = new Form\Entry($sm->get('captcha_options'));
                    $form->setHydrator(new ClassMethods());
                    $form->setInputFilter($sm->get('guestbook_entry_filter'));
                    return $form;
                },
                */
                'guestbook_form_base' => function ($sm) {
                    return new Base($sm->get('captcha_options'));
                },
                'guestbook_entry_form' => function ($sm) {
                    $builder = new AnnotationBuilder();
                    $form = $builder->createForm(new Entity\Entry);
                    $form->add($sm->get('guestbook_form_base'));
                    return $form;
                },
            ),
        );
    }
}
