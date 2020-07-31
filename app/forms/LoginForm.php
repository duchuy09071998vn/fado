<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;

// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email;

class LoginForm extends Form
{
    public function initialize()
    {
        
        // Email Address
         
        $email = new Text('email',
        [
            "class" => "form-group form-box",
            // "required" => true,
            "placeholder" => "Mời nhập địa chỉ email"
        ]);

        // form email field validation
        $email->addValidators(
            [
                new PresenceOf(['message' => 'Yêu cầu bạn nhập Email']),
                new Email(['message' => 'Email của bạn không hợp lệ']),
            ]);

        //Password
        $password = new Password('password',
        [
            "class" => "form-group form-box",
            // "required" => true,
            "placeholder" => "Password"
        ]);
        
        // password field validation
        $password->addValidators(
            [
                new PresenceOf(['message' => ' Yêu cầu nhập password']),
                new StringLength(['min' => 5, 'message' => 'Password của bạn chưa đủ 5 kí tự']),
            ]);

       
         //Submit Button
        
        $submit = new Submit('submit', 
        [
            "value" => "Login",
            "class" => "btn-md btn-theme float-left",
        ]);

        $this->add($email);
        $this->add($password);
        $this->add($submit);
    }
}