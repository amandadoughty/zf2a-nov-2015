<?php
namespace Market\Controller;

use Market\Model\ListingsTableAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTable;

class ViewController extends AbstractActionController implements ListingsTableAwareInterface
{
	protected $listingsTable;
	protected $cityCodesTable;
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
    
	public function cityListAction()
    {
        $alpha = $this->params()->fromRoute('alpha');
        $table = $this->getServiceLocator()->get('city-codes-table');
        if ($alpha) {
            $alpha = strtoupper($alpha);
        } else {
            $alpha = 'A';
        }
        return new ViewModel(['list' => $table->getAllCityCodesByFirstLetter($alpha)]);
    }
    
    public function cityAction()
    {
    	// get country param
    	$countries = $this->params()->fromRoute('countries');
    	if ($countries) {
        	$shortList = $this->listingsTable->getListingsByCountry($countries);
            $viewModel = new ViewModel(array('shortList' 		=> $shortList, 
            						         'categoryParam' 	=> 'City / Country List'));
            $viewModel->setTemplate('market/view/index');
            return $viewModel;
    	}
    	$this->flashMessenger()->addMessage('Unable to locate a city!');
    	return $this->indexAction();
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
