<?php
namespace Search\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\File;
use Search\Form;
use Search\Model\ListingsTable;
use Zend\Session\Container;

class SearchController extends AbstractActionController
{
	protected $listingsTable;
	protected $searchForm;	
	protected $searchFormFilter;	
	protected $categories;
	protected $paginationService;
	protected $paginationConfig;
	
	public function indexAction()
    {
    	// messages
    	if ($this->flashMessenger()->hasMessages()) {
    		$messages = $this->flashMessenger()->getMessages();
    	} else {
    		$messages = array();
    	}
    	
    	// categories are defined in Application/config/module.config.php as a service
    	$categoryAssocList = $this->makeAssoc();

    	// set up form
    	$this->searchForm->prepareElements($categoryAssocList);

        return new ViewModel(array(	'categories' => $this->categories, 
        							'searchForm' => $this->searchForm, 
        							'messages' 	 => $messages,));
    }

    public function listAction()
    {
		$goHome = TRUE;
		    	
    	// pull data from $_POST
   		$data = $this->params()->fromPost();

    	// check to see if submit button pressed
    	if (isset($data['submit'])) {

    		// prepare filters
    		$this->searchFormFilter->prepareFilters($this->categories);
    		$this->searchFormFilter->setData($data);

	    	// validate data against the filter
    		if ($this->searchFormFilter->isValid($data)) {
    			
    			// retrieve filtered and validated data from filter
    			$validData = $this->searchFormFilter->getValues();

				// save searching to database and deal with results
    			$select = $this->paginationService->getSelect($validData); 
    			$paginator = $this->paginationService->search($select); 
    			$session = new Container('pagination');
    			$session->select = $select;
 				if ($paginator) {
					$goHome = FALSE;
				} else {
					// add flash message
					$this->flashMessenger()->addMessage('No results for this search!');
				}				
    		} 
    	}
		if ($goHome) {
			return $this->redirect()->toRoute('search-home');
		} else { 	
    		return new ViewModel(array('categories' => $this->categories, 
    								   'paginationConfig' => $this->paginationConfig,
    								   'paginator' => $paginator));
		}
    }

    public function pageAction()
    {
    	$page = (int) $this->params()->fromRoute('page');
    	if (!$page) {
    		return $this->redirect()->toRoute('search-home');
    	}
   		$session = new Container('pagination');
    	$select = $session->select;
    	$paginator = $this->paginationService->search($select); 
    	$paginator->setCurrentPageNumber($page);
    	$viewModel = new ViewModel(array('categories' => $this->categories, 
    								     'paginationConfig' => $this->paginationConfig,
    								     'paginator' => $paginator));
    	$viewModel->setTemplate('search/search/list.phtml');
    	return $viewModel;
    }
    
    /**
     * Converts numeric array of categories into an associative array
     * 
     * @return Array $categoryAssocList = associative array of categories where key = value
     */
    protected function makeAssoc()
    {
    	$categoryAssocList = array('1' => '-- Choose --');
    	foreach ($this->categories as $item) {
    		$categoryAssocList[$item] = $item;
    	}
    	return $categoryAssocList;
    }

	public function setPaginationConfig($paginationConfig) {
		$this->paginationConfig = $paginationConfig;
	}

    public function setPaginationService($paginationService) {
		$this->paginationService = $paginationService;
	}

    // called by SearchControllerFactory
    public function setListingsTable(ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }
    
    // called by SearchControllerFactory
    public function setSearchForm(Form\SearchForm $form)
    {
    	$this->searchForm = $form;
    }
    
    // called by SearchControllerFactory
    public function setSearchFormFilter(Form\SearchFormFilter $filter)
    {
    	$this->searchFormFilter = $filter;
    }

    // called by SearchControllerFactory
    public function setCategories($categories)
    {
    	$this->categories = $categories;
    }
}
