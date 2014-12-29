<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class SubscriptionForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('subscription');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'send_method',
            'options' => array(
                    'label' => '推送方式',
                    'value_options' => array(
                            '1' => '电子邮件',
                            '2' => '手机短信',
                     ),
             )
        ));
        
        $this->add(array(
        		'name' => 'address',
        		'type' => 'Text',
        ));

        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'filter',
        		'options' => array(
        				'label' => '过滤条件',
        				'value_options' => array(
        						'1' => '大于',
        						'2' => '小于',
        						'3' => '大于等于',
        						'4' => '小于等于',
        						'5' => '等于',
        						'6' => '不等于',
        				),
        		)
        ));
        
        $this->add(array(
        		'name' => 'threshold_value',
        		'type' => 'Text',
        ));
        
        $this->add(array(
        		'type' => 'Zend\Form\Element\Select',
        		'name' => 'send_frequency',
        		'options' => array(
        				'label' => '推送频率',
        				'value_options' => array(
        						'1' => '一分钟一次',
        						'2' => '一小时一次',
        						'3' => '六小时一次',
        						'4' => '一天一次',
        				        '5' => '现在发送',
        				),
        		)
        ));

        $this->add(array(
            'name' => 'subscribe',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '确定',
                'id' => 'subscribebutton',
            ),
        ));
        
        $this->add(array(
        		'name' => 'sensor_id',
        		'type' => 'Hidden',
                'value' => '8',
        ));
        

    }

}