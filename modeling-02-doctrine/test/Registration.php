<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'registration',
   'indexes' => 
   array(
   'IDX_62A8A7A7A9B3AB3C' => 
   array(
    'columns' => 
    array(
    0 => 'eventLink_id',
    ),
   ),
   ),
  ));
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_IMPLICIT);
$metadata->mapField(array(
   'fieldName' => 'id',
   'columnName' => 'id',
   'type' => 'integer',
   'nullable' => false,
   'unsigned' => false,
   'id' => true,
  ));
$metadata->mapField(array(
   'fieldName' => 'firstName',
   'columnName' => 'first_name',
   'type' => 'string',
   'nullable' => false,
   'length' => 255,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'lastName',
   'columnName' => 'last_name',
   'type' => 'string',
   'nullable' => false,
   'length' => 255,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'registrationTime',
   'columnName' => 'registration_time',
   'type' => 'datetime',
   'nullable' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'event',
   'columnName' => 'event',
   'type' => 'integer',
   'nullable' => false,
   'unsigned' => false,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);
$metadata->mapOneToOne(array(
   'fieldName' => 'eventlink',
   'targetEntity' => 'Event',
   'cascade' => 
   array(
   ),
   'mappedBy' => NULL,
   'inversedBy' => NULL,
   'joinColumns' => 
   array(
   0 => 
   array(
    'name' => 'eventLink_id',
    'referencedColumnName' => 'id',
   ),
   ),
   'orphanRemoval' => false,
  ));