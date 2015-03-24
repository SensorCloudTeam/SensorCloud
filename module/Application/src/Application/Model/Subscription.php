<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Subscription implements InputFilterAwareInterface
{
    public $send_method;
    public $address;
    public $filter;
    public $threshold_value;
    public $send_frequency;
    public $sensor_id;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $this->send_method     = (isset($data['send_method']))     ? $data['send_method']     : null;
        $this->address = (isset($data['address'])) ? $data['address'] : null;
        $this->filter  = (isset($data['filter']))  ? $data['filter']  : null;
        $this->threshold_value = (isset($data['threshold_value']))  ? $data['threshold_value']   : null;
        $this->send_frequency = (isset($data['send_frequency']))  ? $data['send_frequency']   : null;
        $this->sensor_id = (isset($data['sensor_id'])) ? $data['sensor_id'] : null;
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
            
            $addressFilter=$factory->createInput(array(
            		'name'       =>  'address',
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
            										\Zend\Validator\NotEmpty::IS_EMPTY => '地址不得为空！'
            								),
            						),
            				),
            		),
            ));
         
        
            $inputFilter->add($addressFilter);
 
            $this->inputFilter = $inputFilter;
            }
            
            return $this->inputFilter;
            }
}