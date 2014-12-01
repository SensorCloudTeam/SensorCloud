<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator;
use Zend\Form\Annotation\Input;
use Zend\Form\Annotation\Options;

class User implements InputFilterAwareInterface
{
    public $email;
    public $username;
    public $password;
    public $password2;
    public $reg_time;
    public $poster;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $this->email     = (isset($data['email']))     ? $data['email']     : null;
        $this->username = (isset($data['username'])) ? $data['username'] : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
        $this->password2 = (isset($data['password2']))  ? $data['password2']   : null;
        $this->poster = (isset($data['poster']))   ? $data['poster']   : null;
    }
 
    // Add content to these methods:
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }
 
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();      
            $factory = new Factory();
            
            $emailFilter=$factory->createInput(array(
            		'name'       =>  'email',
            		'required'   =>  true,
            		'filters'    =>  array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		) ,
            		'validators' =>  array(
            				array(
            						'name'  =>  'not_empty',
            						'options' =>  array(
            								'messages' =>  array(
            										\Zend\Validator\NotEmpty::IS_EMPTY => '邮箱不得为空！'
            								),
            						),
            				),
            		    array(
            		    		'name'        =>  'EmailAddress',
            		    		'options' =>  array(
            		    				'messages' =>  array(
            		    						\Zend\Validator\EmailAddress::INVALID_FORMAT => '邮箱格式不正确！'
            		    				),
            		    		),
            		    ),
            		),
            ));
            
            $usernameFilter=$factory->createInput(array(
            		'name'       =>  'username',
            		'required'   =>  true,
            		'filters'    =>  array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		) ,
            		'validators' =>  array(
            				array(
            						'name'  =>  'not_empty',
            						'options' =>  array(
            								'messages' =>  array(
            										\Zend\Validator\NotEmpty::IS_EMPTY => '用户名不得为空！'
            								),
            						),
            				),
            		),
            ));
            
 
            $passwordFilter = $factory->createInput(array(
                'name'       =>  'password',
                'required'   =>  true,
                'validators' =>  array(
                    array(
                        'name'  =>  'not_empty', 
                        'options' =>  array(
                        		'messages' =>  array(
                        				\Zend\Validator\NotEmpty::IS_EMPTY => '密码不得为空！'
                        		 ),
                        ),
                    ),
                    array(
                    		'name'        =>  'string_length',
                    		'options'     =>  array(
                    				'min'     =>  6,
                    				'messages' =>  array(
                    						'stringLengthTooShort' => '密码长度不得小于6位！'
                    				),
                    		),
                    ),
                 ),
            ));          
        
            $inputFilter->add($emailFilter);
            $inputFilter->add($usernameFilter);
            $inputFilter->add($passwordFilter);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}