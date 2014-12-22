<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class SubscriberController extends AbstractActionController
{
    protected $subscriptionTable;
    protected $sensorTable;
    
    /*服务订阅首页*/
    public function subscriberindexAction()
    {
    	$view = new ViewModel(array(
    	    'sinks' => $this->getSubscriptionTable()->fetchAllSink(),
    	));
    
    	return $view;
    }
    
    public function sinkinfoAction()
    {
        $sink_id = $this->params()->fromRoute('sink_id',0);
    	$view = new ViewModel(array(
    	        'sink' => $this->getSubscriptionTable()->getSink($sink_id),
    			'sensors' => $this->getSensorTable()->fetchAll($sink_id),
    	));
    
    	return $view;
    }
    
    public function mysubscriptionAction()
    {
        $session = new Container('user');
        $username = $_SESSION["username"];
        $view = new ViewModel(array(
        		'subscriptions' => $this->getSubscriptionTable()->fetch($username),
        ));
        $view->setTerminal(true);
        
        return $view;
    }
    
    /*退订服务*/
    public function deletesubscriptionAction()
    {
    	$id = $this->params()->fromRoute('id',0);
    	if($id){
    		$this->getSubscriptionTable()->deleteSubscription($id);
    	}
    	$this->redirect()->toRoute('subscriber',array('action' => 'mysubscription'));
    }
    
    public function getSubscriptionTable()
    {
    	if ($this->subscriptionTable == null) {
    		$sm = $this->getServiceLocator();
    		$this->subscriptionTable = $sm->get('Application\Model\SubscriptionTable');
    	}
    	return $this->subscriptionTable;
    }
    
    public function getSensorTable()
    {
    	if ($this->sensorTable == null) {
    		$sm = $this->getServiceLocator();
    		$this->sensorTable = $sm->get('Application\Model\SensorTable');
    	}
    	return $this->sensorTable;
    }
}