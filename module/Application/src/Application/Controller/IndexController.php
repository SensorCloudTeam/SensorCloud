<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Authentication\Storage\Session as SessionStorage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable;
use Zend\Authentication\Result;
use Zend\Session\Container;
use Application\Model\User;
use Application\Form\UserForm;
use Application\Model\Login;
use Application\Form\LoginForm;
use Application\Model\Changepass;
use Application\Form\ChangepassForm;


class IndexController extends AbstractActionController
{
    protected $userTable;
    protected $subscriptionTable;
    protected $sinkTable;
    protected $sensorTable;
    
    public function indexAction()
    {
        $view = new ViewModel(array(
    	    'sinks' => $this->getSubscriptionTable()->fetchAllSink(),
    	));
    
    	return $view;
    }
    
    /*用户注册*/
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
        		if ($this->getUserTable()->isRegisted($user->email)) {
        		    echo "<script>alert('此邮箱已被注册！')</script>";
        		}elseif($this->getUserTable()->isExist($user->username)){
        		    echo "<script>alert('此用户名已存在！')</script>";
        		}
        		elseif($user->password != $user->password2){
        		    echo "<script>alert('两次密码不一致！')</script>";
        		}
        		else{
        	        $this->getUserTable()->saveUser($user);
        	        echo "<script>alert('注册成功！将跳转到登录页面');window.location.href='/SensorCloud/public/application/login';</script>";        	
        		}
            }
         
        }
        return array('form' => $form);
    }
    
    /*用户登录*/
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
                        $session = new \Zend\Session\Container('user');
                        $_SESSION["username"] = $data["username"];
                        $this->redirect()->toRoute('application',array('action'=>'usercenter'));
                        break;
                    default:
                        break;
       		    }
        	}
        }
        return array('form' => $form);
    }
    
    /*用户注销*/
    public function logoutAction()
    {
        $session = new Container('user');
        unset($_SESSION["username"]);
        session_destroy();
        echo "<script>alert('已退出登录');window.location.href='/SensorCloud/public/';</script>";  
    }
    
    /*用户中心*/
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
    
    public function mycenterAction()
    {
    	$session = new Container('user');
    	$username = $_SESSION["username"];
    	
    	$sub_num = $this->getSubscriptionTable()->getsubnum($username);
    	$sink_num = $this->getSinkTable()->getsinknum($username);
    	$sensor_num = $this->getSensorTable()->getsensornum($username);
    	$post_num = $this->getSensorTable()->getpostnum($username);
    	$view = new ViewModel(array(
    			'name' => $username,
    			'sub_num' => $sub_num,
    			'sink_num'  => $sink_num,
    			'sensor_num' => $sensor_num,
    	        'post_num' => $post_num,
    	));
    
    	$view->setTerminal(true);
    	return $view;
    }
    
    
    /*用户信息*/
    public function userinfoAction()
    {
        date_default_timezone_set('Asia/Taipei'); //设置默认的时区
    	$session = new Container('user');
    	$username = $_SESSION["username"];
    	$email = $this->getUserTable()->getEmail($username);
    	$time = $this->getUserTable()->getTime($username);
    	$poster = $this->getUserTable()->getPoster($username);
    	$view = new ViewModel(array(
    			'name' => $username,
    			'email' => $email,
    			'time'  => date("Y-m-d H:i:s",$time),
    			'poster' => $poster,
    	));
    	$view->setTerminal(true);
    
    	return $view;
    }
    
    /*修改密码*/
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
    				echo "<script>alert('密码修改成功！')</script>";
    			}
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
    
    public function getSubscriptionTable()
    {
    	if ($this->subscriptionTable == null) {
    		$sm = $this->getServiceLocator();
    		$this->subscriptionTable = $sm->get('Application\Model\SubscriptionTable');
    	}
    	return $this->subscriptionTable;
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
