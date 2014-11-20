<?php
namespace Application\Form;
 
use Zend\Form\Form;
 
class LoginForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('login');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'email',
            'type' => 'Text',
            'option' => array(
                'label' => 'email:',),
        ));
      
        $this->add(array(
            'name' => 'password',
            'type' => 'Password',
        ));

        $this->add(array(
            'name' => 'login',
            'type' => 'Submit',
            'attributes' => array(
                'value' => '确认登录',
                'id' => 'loginbutton',
            ),
        ));
    }
}