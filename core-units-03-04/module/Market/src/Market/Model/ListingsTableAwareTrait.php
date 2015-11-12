<?php
namespace Market\Model;

trait ListingsTableAwareTrait
{
    protected $listingsTable;

    public function setListingsTable(ListingsTable $table)
    {
        $this->listingsTable = $table;
    }
}
