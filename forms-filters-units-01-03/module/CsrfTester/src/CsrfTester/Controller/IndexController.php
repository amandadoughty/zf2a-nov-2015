<?php
namespace CsrfTester\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    protected $viewModel;

    public function __construct()
    {
        $this->viewModel = new ViewModel;
        $this->viewModel ->setTerminal(true);

    }
    public function indexAction()
    {
        return $this->viewModel;
    }

    public function maliciousAction()
    {
        return $this->viewModel;
    }
}
