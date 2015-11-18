<?php
namespace Market\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Validator\File;
use Zend\File\Transfer\Adapter\Http as FileTransfer;
use Zend\Mail;
use Zend\Session;
use Market\Model;
use Market\Form;

class PostController extends AbstractActionController
{
	protected $listingsTable;
	protected $cityCodesTable;
	protected $postForm;	
	protected $postFormFilter;	
	protected $mailTransport;
	protected $params;
	protected $emailInfo;
	protected $categories;
				
	public function indexAction()
    {
    	
    	// initialize variables
    	$messages 		= ($this->flashMessenger()->hasMessages()) ? $this->flashMessenger()->getMessages() : array();	
    	$photoFilename 	= '';
		$goHome 		= FALSE;
		    	
    	// retrieve city codes formatted for the form
    	$cityCodes = $this->cityCodesTable->getAllCityCodesForForm();

    	// set up form
    	$this->postForm->prepareElements($this->makeAssoc(), $cityCodes);

    	// pull data from $_POST
   		$data = $this->params()->fromPost();

		// assign data set to form
    	$this->postForm->setData($data);

    	// check to see if submit button pressed
    	if (isset($data['submit'])) {

    		// prepare filters
	    	$this->postFormFilter->prepareFilters($this->categories, $cityCodes);
	    	$this->postForm->setInputFilter($this->postFormFilter);

	    	// validate data against the filter
    		if (!$this->postForm->isValid($data)) {
    			
    			// manage hit count using Zend\Session\*
    			$goHome = $this->manageHitCount($messages);

    		} else {
    			
    			// retrieve filtered and validated data from filter
    			$validData = $this->postFormFilter->getValues();

    			// massage data
				$this->manageValidData($validData);

				// save posting to database and deal with results
				if ($this->listingsTable->add($validData)) {
					// add flash message
					$this->flashMessenger()->addMessage('Your Listing Has Been Posted!');
					// email notification
					$this->sendNotification ($validData['delCode']);
				} else {
					// add flash message
					$this->flashMessenger()->addMessage('Technical Fault: Unable to Post Your Listing!');
				}
				
				// redirect
				$goHome = TRUE;
				
    		}
    	}

    	if ($goHome) {
			// redirect home
    		return $this->redirect()->toRoute('home');
    	}
    	
    	// proceed as planned
	    return new ViewModel(array(	'categories'	=> $this->categories, 
	    							'postForm' 		=> $this->postForm, 
	    							'data' 			=> $data, 
	    							'messages' 		=> $messages));
    }
	/**
	 * Sends email notification
	 * @param string $delCode = delete code 
	 */
	 protected function sendNotification($delCode) 
	 {
		// send confirmation email with edit/delete code
		$emailMessage = new Mail\Message();
		// get "to" and "from" information from "email-info" service defined in email.local.php
		$emailMessage->addTo($this->emailInfo['to'])
					 ->addFrom($this->emailInfo['from'])
		             ->setSubject('Thanks for Posting to the Online Market!')
		             ->setBody('To edit or delete your posting use this key: ' . $delCode)
		             ->setEncoding('utf-8');
		return $this->mailTransport->send($emailMessage);
	}

	/**
	 * @param array $validData
	 */
	 protected function manageValidData(&$validData) 
	 {
		// construct expires date
	 	if (isset($validData['expires']) && $validData['expires']) {
			$date = new \DateTime();
			$interval = '+' . $validData['expires'] . ' day';
			$date->modify($interval);
			$validData['expires'] = $date->format('Y-m-d H:i:s');
		} else {
			// NULL = never expires
			$validData['expires'] = NULL;
		}
		
		// extract city and country
		$cityRow = $this->cityCodesTable->getListingById($validData['cityCode'])->current();
		$validData['city'] 		= $cityRow['city'];
		$validData['country'] 	= $cityRow['ISO2'];
		return TRUE;
	 }

	/**
	 * @param array $messages
	 * @return boolean goHome
	 */
	 protected function manageHitCount(&$messages) 
	 {
	 	$goHome = FALSE;
		// maintain hit counter in session
		$session = new Session\Container('post');
		// check to see if hit count is set
		if ($session->offsetExists('hitCount')) {
			$count = $session->offsetGet('hitCount');
			// check to see if > max
			if ($count > $this->params['hits']) {
				// 0 count, send message, redirect
				$count = 0;
				$session->offsetSet('hitCount', 0);
				$this->flashMessenger()->addMessage('<span style="color: red;">Sorry!  Please retry posting your item!</span>');
				$goHome = TRUE;
			} else {
				$count++;
			}
		} else {
			$count = 1;
		}
		// update counter
		$session->offsetSet('hitCount', $count);
		// add message
		$messages[] = 'Please verify that your post information is correct.';
		return $goHome;
	}


    /**
     * Converts numeric array of categories into an associative array
     * 
     * @return Array $categoryAssocList = associative array of categories where key = value
     */
    protected function makeAssoc()
    {
    	$categoryAssocList = array();
    	foreach ($this->categories as $item) {
    		$categoryAssocList[$item] = $item;
    	}
    	return $categoryAssocList;
    }
    
    // called by PostControllerFactory
    public function setListingsTable(Model\ListingsTable $table)
    {
    	$this->listingsTable = $table;
    }
    
    // called by PostControllerFactory
    public function setCityCodesTable(Model\CityCodesTable $table)
    {
    	$this->cityCodesTable = $table;
    }
    
    // called by PostControllerFactory
    public function setPostForm(Form\PostForm $form)
    {
    	$this->postForm = $form;
    }
    
    // called by PostControllerFactory
    public function setPostFormFilter(Form\PostFormFilter $filter)
    {
    	$this->postFormFilter = $filter;
    }

    // called by PostControllerFactory
    public function setMailTransport($transport)
    {
    	$this->mailTransport = $transport;
    }
    
    // called by PostControllerFactory
    public function setParams($params)
    {
    	$this->params = $params;
    }
    
    // called by PostControllerFactory
    public function setEmailInfo($emailInfo)
    {
    	$this->emailInfo = $emailInfo;
    }
    
    // called by PostControllerFactory
    public function setCategories($categories)
    {
    	$this->categories = $categories;
    }
    
}
