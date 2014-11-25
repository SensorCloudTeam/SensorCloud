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
use Application\Model\Sink;
use Application\Model\UserTable;
use Application\Model\SinkTable;
use Application\Form\UserForm;
use Application\Form\LoginForm;
use Application\Form\SinkForm;
use Application\Model\Login;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\Result;

class IndexController extends AbstractActionController
{
    protected $userTable;
    protected $sinkTable;
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
        		$auth = new AuthenticationService();
        	    $auth->setStorage(new SessionStorage('user'));
        	    
       		    $data = $form->getData();
       		    $sm          = $this->getServiceLocator();
       		    $dbAdapter   = $sm->get('db_adapter');
       		    $authAdapter = new DbTable($dbAdapter, 'user', 'id', 'password');
       		    
       		    $authAdapter
       		        ->setIdentity($data['username'])
       		        ->setCredential(sha1($data['password']));  		    
        	
       		    $result = $auth->authenticate($authAdapter);    
       		    switch ($result->getCode()) {
       		        case Result::FAILURE_IDENTITY_NOT_FOUND:
       		            echo "<script>alert('用户名不存在！')</script>";
                        break;
                    case Result::FAILURE_CREDENTIAL_INVALID:
                        echo "<script>alert('密码错误')</script>";
                        break;
                    case Result::SUCCESS:
                        $storage = $auth->getStorage();
                        $storage->write($authAdapter->getResultRowObject());
                        
                        $session = new \Zend\Session\Container('bdm');
                        $this->redirect()->toRoute('application',array('action'=>'usercenter'));
                        break;
                    default:
                        break;
       		    }
        	}
        }
        return array('form' => $form);
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
    
    public function usercenterAction()
    {
    	return new ViewModel();
    }
}
