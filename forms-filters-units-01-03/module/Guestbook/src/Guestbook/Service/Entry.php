<?php
namespace Guestbook\Service;

use Guestbook\Entity\Entry as EntryEntity;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Zend\ServiceManager\ServiceManager;

class Entry implements
    ServiceManagerAwareInterface,
    EventManagerAwareInterface
{
    protected $serviceManager;

    protected $eventManager;

    protected $entryMapper;

    public function add(array $data)
    {
        $form = $this->getServiceManager()->get('guestbook_entry_form');
        $form->bind(new EntryEntity());
        $form->setData($data);

        if (!$form->isValid()) {
            return false;
        }

        $entry = $form->getData();

        $this->getEventManager()->trigger(__FUNCTION__ . '.pre', $this, array('entry' => $entry));
        $this->getEntryMapper()->insert($entry);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('entry' => $entry));

        return $entry;
    }

    public function findAll()
    {
        return $this->getEntryMapper()->findAll();
    }

    public function getEntryMapper()
    {
        if (null === $this->entryMapper) {
            $this->entryMapper = $this->getServiceManager()->get('guestbook_entry_mapper');
        }

        return $this->entryMapper;
    }

    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    public function setServiceManager(ServiceManager $serviceManager)
    {
        $this->serviceManager = $serviceManager;
        return $this;
    }

    public function getEventManager()
    {
        return $this->eventManager;
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        $this->eventManager = $eventManager;
        return $this;
    }
}