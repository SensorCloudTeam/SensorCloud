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
    	$view = new ViewModel();
    
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
    
    /*添加发布结点*/
    public function addsinkAction()
    {
      
    	$form = new SinkForm();
    
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$sink = new Sink();
    		$form->setInputFilter($sink->getInputFilter());
    		$form->setData($request->getPost());
    		 
    		if ($form->isValid()) {
    			$sink->exchangeArray($form->getData());
    			$this->getSinkTable()->addSink($sink);
    			echo "<script>alert('您的设备号为 $sink->id');window.location.href='/SensorCloud/public/poster/mysink';</script>";
    		}
    		 
    		}
    		
    		$view = new ViewModel(array(
    		                        "form" => $form,
    		));
    		$view->setTerminal(true);
    		return $view;
    }
    
    /*删除发布结点*/
    public function deletesinkAction()
    {
        $id = $this->params()->fromRoute('id',0);
        if($id){
            $this->getSinkTable()->deleteSink($id);     
        }
        $this->redirect()->toRoute('poster',array('action' => 'mysink'));
    }
    
    public function mysensorAction()
    {
    	$id = $this->params()->fromRoute('sink_id',0);
    	$view = new ViewModel(array(
    			'sensors' => $this->getSensorTable()->fetchAll($id),
    	        'sink_id' => $id,
    	));
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    public function addsensorAction()
    {
        $form = new SensorForm();
        $sink_id = $sink_id = $this->params()->fromRoute('sink_id',0);
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
        	"form" => $form,
        	));
        	$view->setTerminal(true);
        	return $view;
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