<?php
namespace Market\Controller;

use Market\Model\ListingsTableAwareInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Market\Model\ListingsTable;

class IndexController extends AbstractActionController implements ListingsTableAwareInterface
{
	protected $listingsTable;
	
    public function indexAction()
    {
    	// latest listing by entry ID
    	$latest 	= $this->listingsTable->getLatestListing();
    	// check for messages
    	$messages 	= ($this->flashMessenger()->hasMessages()) ? $this->flashMessenger()->getMessages() : NULL;	
    	// done
        return new ViewModel(array('latest' 	=> $latest, 
        						   'messages' 	=> $messages));
    }
    
    // called by IndexControllerFactory
    public function setListingsTable(ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }
    
}
