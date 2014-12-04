<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class ChangepassForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        
        $this->add(array(
            'name' => 'oldpassword',
            'type' => 'Password',
        ));
        $this->add(array(
        	'name' => 'newpassword',
        	'type' => 'Password', 
        ));
        $this->add(array(
        		'name' => 'newpassword2',
        		'type' => 'Password',
        ));

        $this->add(array(
            'name' => 'changepass',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '确认修改',
                'id' => 'changepassbutton',
            ),
        ));
    }
}