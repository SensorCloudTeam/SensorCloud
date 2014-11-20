<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Model\User;
use Application\Model\UserTable;
use Application\Form\UserForm;
use Application\Form\LoginForm;

class IndexController extends AbstractActionController
{
    protected $userTable;
    public function indexAction()
    {
        return new ViewModel();
    }
    
    public function registerAction()
    {
        $form = new UserForm();
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$user = new User();
        	$form->setInputFilter($user->getInputFilter());
        	$form->setData($request->getPost());
        	
        	if(!$form->isValid()){
        		$user->exchangeArray($form->getData());
        		if(!$user->emailFilter1->isValid()){
        			echo "<script>alert('email不得为空！')</script>";
        		}
        		if(!$user->emailFilter2->isValid()){
        			echo "<script>alert('email格式错误！')</script>";
        		}
        		if(!$user->passwordFilter1->isValid()){
        			echo "<script>alert('密码不得为空！')</script>";
        		}
        		if(!$user->passwordFilter2->isValid()){
        			echo "<script>alert('密码长度不得少于6位！')</script>";
        		}
        	}
        	if ($form->isValid()) {
        		$user->exchangeArray($form->getData());
        		if($user->password != $user->password2){
        		    echo "<script>alert('两次密码不一致！')</script>";
        		}
        		else{
        	    $this->getUserTable()->saveUser($user);
        		// Redirect to list of albums
        		return $this->redirect()->toRoute('home');
        		}
            }
         
        }
        return array('form' => $form);
    }
    
    public function getUserTable()
    {
    	if ($this->userTable == null) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('Application\Model\UserTable');
    	}
    	return $this->userTable;
    }
    
    public function loginAction()
    {
        $form = new LoginForm();
        
        $request = $this->getRequest();
     
        return array('form' => $form);
    }
}
