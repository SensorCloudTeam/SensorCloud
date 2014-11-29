<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Sink;
use Application\Model\SinkTable;
use Application\Form\SinkForm;

/**
 * PosterController
 *
 * @author
 *
 * @version
 *
 */
class PosterController extends AbstractActionController
{

    protected $sinkTable;
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
    			echo "<script>alert('您的设备号为 $sink->id')</script>";
    		}
    		 
    		}
    		return array('form' => $form);
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