<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Form\SubscriptionForm;
use Application\Model\Subscription;
use Zend\Mail\Message;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mail\Transport\Smtp;

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
    
    /*节点信息及服务订阅*/
    public function sinkinfoAction()
    {
        $form = new SubscriptionForm();
       
        $sink_id = $this->params()->fromRoute('sink_id',0);
    	$view = new ViewModel(array(
    	        'sink' => $this->getSubscriptionTable()->getSink($sink_id),
    			'sensors' => $this->getSensorTable()->fetchAllPosted($sink_id),
    	        'form' => $form,
    	));
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$subscription = new Subscription();
    		$form->setInputFilter($subscription->getInputFilter());
    		$form->setData($request->getPost());
    
    		if ($form->isValid()) {
    			$data = $form->getData();
    			$sensor_id = $data['sensor_id'];
    			$body = $this->getSensorTable()->getMsg($sensor_id);
    			$subscription->exchangeArray($data);
    			if ($data['send_frequency']=='5') {
    				$session = new Container('user');
    				$username = $_SESSION["username"];
    				$msg = new Message();
    				$msg->setFrom("ECNU_Sei_Lab301@163.com","SensorCloud")
    				->setTo($data['address'],$username)
    				->setSubject("SensorCloud服务订阅")
    				->setBody($body);
    				$smtpOpt = new SmtpOptions(array(
    						'name' => 'smtp.163.com',
    						'host' => 'smtp.163.com',
    						'port' => 25,
    						'connection_class' => 'login',
    						'connection_config' => array(
    								'username' => 'ECNU_Sei_Lab301@163.com',
    								'password' => 'seilab301',),
    						 
    				));
    				$trans = new Smtp();
    				$trans->setOptions($smtpOpt);
    				$trans->send($msg);
    				echo "<script>alert('订阅数据已发送，请您及时查收邮件！');</script>";
    			}
    			else{
    				$this->getSubscriptionTable()->Subscribe($subscription);
    				echo "<script>alert('已成功订阅服务！');</script>";
    			}
    			}
    	
    			}
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