<?php
namespace Application\Model;
 
// Add these import statements
use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class Sink implements InputFilterAwareInterface
{
    public $user_id;
    public $id;
    public $name;
    public $longitude;
    public $latitude;
    protected $inputFilter;                       // <-- Add this variable
 
    public function exchangeArray($data)
    {
        $session = new \Zend\Session\Container('user');
        $this->user_id     =(isset($_SESSION["username"]))? $_SESSION["username"] : null;
        $id = $this->randPass(8);
        $this->id  = $id;
        $this->name  = (isset($data['name']))  ? $data['name']  : null;
        $this->longitude  = (isset($data['longitude']))  ? $data['longitude']  : null;
        $this->latitude  = (isset($data['latitude']))  ? $data['latitude']  : null;
    }
    

    public function randPass($length)
    {
    	$randStr = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZqwertyuioplkjhgfdsazxcvbnm1234567890');
    	$rand = substr($randStr,0,$length);
    	return $rand;
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
            										\Zend\Validator\NotEmpty::IS_EMPTY => '节点名称不得为空！'
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