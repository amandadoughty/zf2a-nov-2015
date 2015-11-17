<?php
namespace Guestbook\Mapper;

use Zend\Stdlib\Hydrator\HydratorInterface;

class EntryHydrator implements HydratorInterface
{
    public function extract($object)
    {
        return array(
            'entry_id'      => $object->getId(),
            'entry_name'    => $object->getName(),
            'entry_email'   => $object->getEmail(),
            'entry_website' => $object->getWebsite(),
            'entry_message' => $object->getMessage(),
        );
    }

    public function hydrate(array $data, $object)
    {
        $object->setId($data['entry_id'])
               ->setName($data['entry_name'])
               ->setEmail($data['entry_email'])
               ->setWebsite($data['entry_website'])
               ->setMessage($data['entry_message']);

        return $object;
    }
}