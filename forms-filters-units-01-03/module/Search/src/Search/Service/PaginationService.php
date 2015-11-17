<?php
namespace Search\Service;

use Search\Model\ListingsTable;
use Zend\Db\Sql;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class PaginationService
{
	protected $listingsTable;
	protected $config;
	protected $paginator = NULL;
	protected $select = '';
	protected $searchFormMappings = array(
			'category' 		=> 'category',
			'title' 		=> 'title',
			'priceMin' 		=> 'price',
			'priceMax' 		=> 'price',
			'expires' 		=> 'date_expires',
			'city' 			=> 'city',
			'country' 		=> 'country',
			'name' 			=> 'contact_name',
			'phone' 		=> 'contact_phone',
			'email' 		=> 'contact_email',
			'description' 	=> 'description'
	);
	
    public function search($select)
    {
    	if ($this->select !== $select) { 
	        $paginatorAdapter = new DbSelect($select, $this->listingsTable->getAdapter());
	        $this->paginator = new Paginator($paginatorAdapter);
	        $this->paginator->setItemCountPerPage($this->config['itemsPerPage']);
    	}
		return $this->paginator;
    }
    
    public function getSelect(Array $data)
    {
		$select = new Sql\Select();
		$select->from($this->listingsTable->tableName);
		$where = new Sql\Where();	
		// key = form field; value = column name
		foreach ($this->searchFormMappings as $key => $value) {
			if ($data[$key]) {
				if ($key == 'priceMin') {
					$where->greaterThanOrEqualTo($value, $data[$key]);
				} elseif ($key == 'priceMax') {
					$where->lessThanOrEqualTo($value, $data[$key]);
				} elseif ($key == 'category' && $data[$key] == '1') {
					continue;
				} else {
					$where->like($value, '%' . $data[$key] . '%');
				}
			}
		}
		$select->where($where);
		return $select;
    }
    public function setListingsTable($listingsTable) {
		$this->listingsTable = $listingsTable;
	}

	public function setConfig($config) {
		$this->config = $config;
	}    
}
