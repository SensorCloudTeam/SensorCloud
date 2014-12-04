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
            'name' => 'email',
            'type' => 'Text',
            'option' => array(
                'label' => 'email:',),
        ));
        $this->add(array(
            'name' => 'username',
            'type' => 'Text',
        ));
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
        ));
        $this->add(array(
        	'name' => 'password2',
        	'type' => 'Password', 
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Radio',
            'name' => 'poster',
            'options' =>array(
                'label'  =>  '是否为信息发布方？',
                'value_options' =>  array(
                    '1'  =>  '是',
                    '0'  =>  '否',
                 ),
            ),
            'attributes' => array(
            		'value' => '0' //set checked to '1'
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '注册',
                'id' => 'registerbutton',
            ),
        ));
    }
}