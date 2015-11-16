<?php

use Doctrine\ORM\Mapping\ClassMetadataInfo;

$metadata->setInheritanceType(ClassMetadataInfo::INHERITANCE_TYPE_NONE);
$metadata->setPrimaryTable(array(
   'name' => 'event',
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
   'fieldName' => 'name',
   'columnName' => 'name',
   'type' => 'string',
   'nullable' => false,
   'length' => 255,
   'fixed' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'maxAttendees',
   'columnName' => 'max_attendees',
   'type' => 'integer',
   'nullable' => false,
   'unsigned' => false,
  ));
$metadata->mapField(array(
   'fieldName' => 'date',
   'columnName' => 'date',
   'type' => 'datetime',
   'nullable' => false,
  ));
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_IDENTITY);