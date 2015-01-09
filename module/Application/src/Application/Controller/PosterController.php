<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Model\Sink;
use Application\Model\Sensor;
use Application\Form\SinkForm;
use Application\Form\SensorForm;

class PosterController extends AbstractActionController
{

    protected $sinkTable;
    protected $sensorTable;
    
    /*服务发布首页*/
    public function posterindexAction()
    {
    	$form = new SinkForm();
    
    	$session = new Container('user');
    	$username = $_SESSION["username"];
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$sink = new Sink();
    		$form->setInputFilter($sink->getInputFilter());
    		$form->setData($request->getPost());
    		 
    		if ($form->isValid()) {
    			$sink->exchangeArray($form->getData());
    			$this->getSinkTable()->addSink($sink);
    			echo "<script>alert('您的设备号为：$sink->id');window.location.href='/SensorCloud/public/application/usercenter';</script>";
    		}
    		}
    		
    		$view = new ViewModel(array(
    		     "form" => $form,
    		    'sinks' => $this->getSinkTable()->fetchAll($username),
    		));
    		
    		return $view;
    }

    /*获取发布结点列表*/
    public function mysinkAction()
    {
        $session = new Container('user');
        $username = $_SESSION["username"];
    	$view = new ViewModel(array(
            'sinks' => $this->getSinkTable()->fetchAll($username),
        ));
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    /*删除发布结点*/
    public function deletesinkAction()
    {
        $sink_id = $this->params()->fromRoute('sink_id',0);
        if($sink_id){
            $this->getSinkTable()->deleteSink($sink_id);     
        }
        $this->redirect()->toRoute('poster',array('action' => 'mysink'));
    }
    
    public function mysensorAction()
    {
    	$sink_id = $this->params()->fromRoute('sink_id',0);
    	$sink_name = $this->getSinkTable()->getName($sink_id);
    	$view = new ViewModel(array(
    			'sensors' => $this->getSensorTable()->fetchAll($sink_id),
    	        'sink_id' => $sink_id,
    	        'sink_name' => $sink_name,
    	));
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    public function addsensorAction()
    {
        $form = new SensorForm();
        $sink_id = $sink_id = $this->params()->fromRoute('sink_id',0);
        $sink_name = $this->getSinkTable()->getName($sink_id);
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$sensor = new Sensor();
        	$form->setInputFilter($sensor->getInputFilter());
        	$form->setData($request->getPost());
        	 
        	if ($form->isValid()) {
        		$sensor->exchangeArray($form->getData());
        		$this->getSensorTable()->addSensor($sensor,$sink_id);
        		$this->redirect()->toRoute('poster',array('action' => 'mysensor','sink_id' => $sink_id));
        	}
        	 
        	}
        
        	$view = new ViewModel(array(
        	      'form' => $form,
        	      'sink_id' => $sink_id,
        	      'sink_name' => $sink_name,
        	));
        	$view->setTerminal(true);
        	return $view;
    }
    
    public function postsensorAction()
    {
    	$sink_id = $this->params()->fromRoute('sink_id',0);
    	$sensor_id = $this->params()->fromRoute('sensor_id',0);
    	if($sensor_id){
    		$this->getSensorTable()->postSensor($sensor_id);
    	}
    	
    	$this->redirect()->toRoute('poster',array('action' => 'mysensor','sink_id' => $sink_id));
    }
    
    public function canclepostsensorAction()
    {
    	$sink_id = $this->params()->fromRoute('sink_id',0);
    	$sensor_id = $this->params()->fromRoute('sensor_id',0);
    	if($sensor_id){
    		$this->getSensorTable()->canclepostSensor($sensor_id);
    	}
    	
    	$this->redirect()->toRoute('poster',array('action' => 'mysensor','sink_id' => $sink_id));
    }
    
    /*删除传感器*/
    public function deletesensorAction()
    {
    	$sink_id = $this->params()->fromRoute('sink_id',0);
    	$sensor_id = $this->params()->fromRoute('sensor_id',0);
    	if($sensor_id){
    		$this->getSensorTable()->deleteSensor($sensor_id);
    	}
    	$this->redirect()->toRoute('poster',array('action' => 'mysensor','sink_id' => $sink_id));
    }
    
    public function getSinkTable()
    {
    if ($this->sinkTable == null) {
    	$sm = $this->getServiceLocator();
    		$this->sinkTable = $sm->get('Application\Model\SinkTable');
    	}
    	return $this->sinkTable;
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