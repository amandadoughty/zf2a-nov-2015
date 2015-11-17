<?php
namespace Guestbook\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $prg          = $this->prg();
        $entryForm    = $this->getServiceLocator()->get('guestbook_entry_form');
        $entryService = $this->getServiceLocator()->get('guestbook_entry_service');

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg !== false) {
            $entry = $entryService->add($prg);

            if ($entry) {
                return $this->redirect()->toRoute('guestbook');
            }
        }

        return new ViewModel(array(
//        	  'form' => $entryForm,
            'entryForm' => $entryForm,
            'entries'   => $entryService->findAll()
        ));
    }
}
