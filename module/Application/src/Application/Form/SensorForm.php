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
            'name' => 'type_id',
            'options' => array(
                    'label' => '选择传感器类型',
                    'value_options' => array(
                            '1' => '温度',
                            '2' => '湿度',
                            '3' => 'PH值',
                            '4' => '光照强度',
                            '5' => '车流量',
                            '6' => '图片',
                            '7' => '视频' ,
                            '8' => '自定义数值类型',
                     ),
             )
        ));
        $this->add(array(
       		'type' => 'Zend\Form\Element\Radio',
       		'name' => 'post',
       		'options' =>array(
       		         'label'  =>  '是否发布？',
         			 'value_options' =>  array(
         				    '1'  =>  '是',
         					'0'  =>  '否',
         				),
         		),
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