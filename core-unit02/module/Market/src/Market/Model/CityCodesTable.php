<?php
namespace Market\Model;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;

class CityCodesTable extends TableGateway
{
	public $tableName = 'world_city_area_codes';
	public $primaryKey = 'world_city_area_code_id';
	
	// SELECT * FROM `world_city_area_codes`
	public function getAllCityCodes()
	{
		$select = new Select();
		$select->from($this->tableName);
		$select->order('city ASC');
		$where = new Where();
		$where->isNotNull('city');
		$select->where($where);
		return $this->selectWith($select);	
	}

	/**
	 * Returns an associative array: key = id => value = name of city
	 * @return Array $cityCodes
	 */
	public function getAllCityCodesForForm()
	{
		$cityCodesForForm = array();
		$cityCodesAll = $this->getAllCityCodes();
		foreach ($cityCodesAll as $city) {
			if (strlen($city->city) > 1) {
				$cityCodesForForm[$city[$this->primaryKey]] = $city->city . ', ' . $city->ISO2;
			}
		}
		return $cityCodesForForm;
	}
	
	// SELECT * FROM `listings` WHERE `listings_id` = ? LIMIT 1
	public function getListingById($id = 1)
	{
		$select = new Select();
		$select->from($this->tableName);
		$where = new Where();
		$where->equalTo($this->primaryKey, $id);
		$select->where($where);
		$select->limit(1);
		return $this->selectWith($select);	
	}

}