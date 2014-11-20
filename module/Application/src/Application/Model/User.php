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
    public $poster;
    public $emailFilter1;
    public $emailFilter2;
    public $passwordFilter1;
    public $passwordFilter2;
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
            
            $this->emailFilter1=$factory->createInput(array(
            		'name'       =>  'email',
            		'required'   =>  true,
                    'filters'    =>  array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
            ) ,
            		'validators' =>  array(
            				array(
            						'name'  =>  'not_empty',
            				),
            		),
            ));
            
            $this->emailFilter2=$factory->createInput(array(
            		'name'       =>  'email',
            		'required'   =>  true,
            		'filters'    =>  array(
            				array('name' => 'StripTags'),
            				array('name' => 'StringTrim'),
            		) ,
            		'validators' =>  array(
            				array(
            						'name'        =>  'EmailAddress',
            				),
            		),
            ));
            
            $this->passwordFilter1 = $factory->createInput(array(
                'name'       =>  'password',
                'required'   =>  true,
                'validators' =>  array(
                    array(
                        'name'  =>  'not_empty',  
                    ),
                ),
            ));
            
            $this->passwordFilter2 = $factory->createInput(array(
                'name'       =>  'password',
                'required'   =>  true,
                'validators' =>  array(
                    array(
                        'name'        =>  'string_length',
                        'options'     =>  array(
                            'min'     =>  6, 
                         ),
                    ),
                ),
            ));
        
            $inputFilter->add($this->emailFilter1);
            $inputFilter->add($this->emailFilter2);
            $inputFilter->add($this->passwordFilter1);
            $inputFilter->add($this->passwordFilter2);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}