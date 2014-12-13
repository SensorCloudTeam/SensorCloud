<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SubscriberController extends AbstractActionController
{

   

    /*获取发布结点列表*/
    public function subscribeIndexAction()
    {
    	$view = new ViewModel();
    	$view->setTerminal(true);
    
    	return $view;
    }
    
}