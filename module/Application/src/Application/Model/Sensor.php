<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Sensor implements InputFilterAwareInterface
{
    public $name;
    public $type_id;
    public $post;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $this->name  = (isset($data['name']))  ? $data['name']  : null;
        $this->type_id = (isset($data['type_id']))  ? $data['type_id']  : null;
        $this->post  = (isset($data['post'])) ? $data['post']  : null;
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
            
            $nameFilter=$factory->createInput(array(
            		'name'       =>  'name',
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
            										\Zend\Validator\NotEmpty::IS_EMPTY => '传感器名称不得为空！'
            								),
            						),
            				),
            		),
            ));
         
        
            $inputFilter->add($nameFilter);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}