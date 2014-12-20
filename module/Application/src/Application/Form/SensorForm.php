<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class SensorForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('sensor');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'name',
            'type' => 'Text',
        ));
         $this->add(array(
             'type' => 'Zend\Form\Element\Select',
             'name' => 'type',
             'options' => array(
                     'label' => '选择传感器类型',
                     'value_options' => array(
                             '1' => '温度',
                             '2' => '湿度',
                             '3' => 'PH',
                             '4' => '车流量',
                     ),
             )
     ));

        $this->add(array(
            'name' => 'addsensor',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '添加传感器',
                'id' => 'addsensorbutton',
            ),
        ));
    }
}