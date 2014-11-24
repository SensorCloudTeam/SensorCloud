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
use Application\Model\Login;

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
        	
        	if ($form->isValid()) {
        		$user->exchangeArray($form->getData());
        		if ($this->getUserTable()->isExist($user->username)) {
        			echo "<script>alert('此用户名已存在！')</script>";
        		}
        		elseif($user->password != $user->password2){
        		    echo "<script>alert('两次密码不一致！')</script>";
        		}
        		else{
        	        $this->getUserTable()->saveUser($user);
        	        echo "<script>alert('注册成功！将跳转到登录页面')</script>";
        	        return $this->redirect()->toRoute('application',array('action'=>'login'));
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
        if ($request->isPost()) {
        	$login = new Login();
        	$form->setInputFilter($login->getInputFilter());
        	$form->setData($request->getPost());
        	 
        	if ($form->isValid()) {
        		$login->exchangeArray($form->getData());
        		if (!$this->getUserTable()->isExist($login->username)) {
        			echo "<script>alert('此用户名不存在！')</script>";
        		}
        		else{
        		    if($this->getUserTable()->rightPass($login->username,$login->password)){
        		        return $this->redirect()->toRoute('home');
        		    }
        		    else{
        		        echo "<script>alert('密码错误！')</script>";
        		    }
        		}
        	}
        	 
        }
     
        return array('form' => $form);
    }
}
