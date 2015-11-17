<?php
namespace Guestbook\Mapper;

use ZfcBase\Mapper\AbstractDbMapper;
use Zend\Stdlib\Hydrator\HydratorInterface;

class Entry extends AbstractDbMapper
{
    protected $tableName = 'guestbook_entry';

    public function insert($entity, $tableName = NULL, HydratorInterface $hydrator = NULL)
    {
        $result = parent::insert($entity);
        $entity->setId($result->getGeneratedValue());
        return $result;
    }

    public function findAll()
    {
        $select = $this->getSelect()
            //->from($this->tableName)
            ->order('entry_id');

        return $this->select($select);
    }
}
