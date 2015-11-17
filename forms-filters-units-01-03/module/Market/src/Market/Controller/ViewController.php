<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTable;

class ViewController extends AbstractActionController
{
	protected $listingsTable;
	protected $categories;
		
	public function indexAction()
    {
    	// get category param
    	$categoryParam = $this->params()->fromRoute('cat');
    	// get short listing for this category
    	$categoryParam = ($categoryParam) ? $categoryParam : $this->categories[array_rand($this->categories)];
    	$shortList = $this->listingsTable->getListingsByCategory($categoryParam);
        return new ViewModel(array('shortList' 		=> $shortList, 
        						   'categoryParam' 	=> $categoryParam));
    }
    
    public function itemAction()
    {
    	// get listings ID param
    	$id = (int) $this->params()->fromRoute('id');
    	$item = $this->listingsTable->getListingById($id);
        return new ViewModel(array('categories' => $this->categories, 
        						   'item' => $item));
    }
    
    // called by ViewControllerFactory
    public function setListingsTable(ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }

    // called by ViewControllerFactory
    public function setCategories($categories)
    {
    	$this->categories = $categories;
    }
}
