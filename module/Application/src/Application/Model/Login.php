<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Login implements InputFilterAwareInterface
{
    public $username;
    public $password;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $this->username     = (isset($data['username']))     ? $data['username']     : null;
        $this->password  = (isset($data['password']))  ? $data['password']  : null;
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
                 ),
            ));          
        
            $inputFilter->add($usernameFilter);
            $inputFilter->add($passwordFilter);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}