<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
use Application\Model\Sink;
use Application\Form\SinkForm;

class PosterController extends AbstractActionController
{

    protected $sinkTable;

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
    			$this->getSinkTable()->saveSink($sink);
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
    
    public function getSinkTable()
    {
    if ($this->sinkTable == null) {
    	$sm = $this->getServiceLocator();
    		$this->sinkTable = $sm->get('Application\Model\SinkTable');
    	}
    	return $this->sinkTable;
    }
}