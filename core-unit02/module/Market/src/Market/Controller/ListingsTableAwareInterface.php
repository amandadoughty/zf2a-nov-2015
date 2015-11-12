<?php
namespace Market\Controller;

use Market\Model\ListingsTable;

interface ListingsTableAwareInterface
{
    public function setListingsTable(ListingsTable $table);
}