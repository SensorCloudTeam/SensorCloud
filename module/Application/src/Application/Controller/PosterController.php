<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\Sink;
use Application\Model\SinkTable;
use Application\Form\SinkForm;
use Zend\Session\Container;
use Application\Model\Changepass;
use Application\Form\ChangepassForm;

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
    protected  $userTable;
    public function usercenterAction()
    {
    	$view = new ViewModel();
    
    	return $view;
    }
    
    public function userframeAction()
    {
    	$view = new ViewModel();
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    public function userguideAction()
    {
    	$view = new ViewModel();
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    public function userinfoAction()
    {
    	$session = new Container('user');
    	$username = $_SESSION["username"];
    	$email = $this->getUserTable()->getEmail($username);
    	$time = $this->getUserTable()->getTime($username);
    	$poster = $this->getUserTable()->getPoster($username);
        $view = new ViewModel(array(
                                'name' => $username,
                                'email' => $email,
                                'time'  => $time,
                                'poster' => $poster
        ));
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    public function changepassAction()
    {
        $form = new ChangepassForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$changepass = new Changepass();
        	$form->setInputFilter($changepass->getInputFilter());
        	$form->setData($request->getPost());
        
        	if ($form->isValid()) {
        		$changepass->exchangeArray($form->getData());
        		$session = new Container('user');
        		$username = $_SESSION["username"];
        		if($this->getUserTable()->getPass($username) != sha1($changepass->oldpassword)){
        		    echo "<script>alert('旧密码不正确！')</script>";
        		}elseif($changepass->newpassword != $changepass->newpassword2){
        		    echo "<script>alert('两次密码不一致！')</script>";
        		}else{
        		    $this->getUserTable()->changePass($username,$changepass->newpassword);
        		}		 
        	}
        }
	    $view = new ViewModel(array(
    		                        "form" => $form,
    	));
    	$view->setTerminal(true);
    	return $view;      
    }
    
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
    		
    		$view = new ViewModel(array(
    		                        "form" => $form,
    		));
    		$view->setTerminal(true);
    		return $view;
    }
    
    public function getUserTable()
    {
    	if ($this->userTable == null) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('Application\Model\UserTable');
    	}
    	return $this->userTable;
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