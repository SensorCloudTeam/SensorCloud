<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class SinkForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('sink');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'user_id',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'id',
            'type' => 'Text',
        ));
         $this->add(array(
        		'name' => 'longitude',
        		'type' => 'Hidden',
                'value' => "121.412158",
        ));
         $this->add(array(
         		'name' => 'latitude',
         		'type' => 'Hidden',
                'value' => "31.23613",
         ));

        $this->add(array(
            'name' => 'addsink',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '获得设备号',
                'id' => 'addsinkbutton',
            ),
        ));
    }
}