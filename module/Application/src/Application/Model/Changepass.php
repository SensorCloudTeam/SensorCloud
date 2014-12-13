<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class Changepass implements InputFilterAwareInterface
{
    public $oldpassword;
    public $newpassword;
    public $newpassword2;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $this->oldpassword     = (isset($data['oldpassword']))     ? $data['oldpassword']     : null;
        $this->newpassword  = (isset($data['newpassword']))  ? $data['newpassword']  : null;
        $this->newpassword2  = (isset($data['newpassword2']))  ? $data['newpassword2']  : null;
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
            
            $oldpasswordFilter=$factory->createInput(array(
            		'name'       =>  'oldpassword',
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
            										\Zend\Validator\NotEmpty::IS_EMPTY => '旧密码不得为空！'
            								),
            						),
            				),
            		),
            ));
 
            $newpasswordFilter = $factory->createInput(array(
                'name'       =>  'newpassword',
                'required'   =>  true,
                'validators' =>  array(
                    array(
                        'name'  =>  'not_empty', 
                        'options' =>  array(
                        		'messages' =>  array(
                        				\Zend\Validator\NotEmpty::IS_EMPTY => '新密码不得为空！'
                        		 ),
                        ),
                    ),
                 ),
            ));          
        
            $inputFilter->add($oldpasswordFilter);
            $inputFilter->add($newpasswordFilter);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}