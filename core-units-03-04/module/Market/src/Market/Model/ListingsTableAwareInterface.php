<?php
namespace Market\Model;

interface ListingsTableAwareInterface
{
    public function setListingsTable(ListingsTable $listingsTable);
}
