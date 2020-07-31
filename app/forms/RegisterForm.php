<?php
 namespace App\Forms;
use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;

use Phalcon\Validation;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;


class RegisterForm extends Form
{
    public function initialize()
    {
        //form name field
        $name = new Text(
            'name',
            [
                "class" => "form-group form-box", 
                "placeholder" => "Mời bạn nhập đầy đủ tên"
                
            ]
            );
        
        //form name field  Validation
        $name ->addValidator(
            new PresenceOf(['message' => 'Yêu cầu nhập tên ',])
        );
             
        //form email field
        $email = new Text(
            'email',
            [
                "class" => "form-group form-box",
                 "placeholder" => "Mời bạn nhập email"
            ]
            );

        //form email field  Validation
        $email ->addValidator(
            new PresenceOf(['message' => 'Yêu cầu nhập email ',])
        );    

        $email ->addValidator(
            new Email(['message' => 'Email không hợp lệ',])  
        );  

        

         // New Password
         
        $password = new Password('password', [
            "class" => "form-group form-box",
            // "required" => true,
            "placeholder" => "Mời bạn nhập mật khẩu"
        ]);

        $password->addValidators([
            new PresenceOf(['message' => 'Yêu cầu nhập password']),
            new StringLength(['min' => 5, 'message' => 'Password của bạn ít nhất 5 kí tự']),
            new Confirmation(['with' => 'password_confirm', 'message' => 'Mật khẩu không giống']),
        ]);


        
         // Confirm Password
         
        $passwordNewConfirm = new Password('password_confirm', [
            "class" => "form-group form-box ",
            // "required" => true,
            "placeholder" => "Xác nhận mật khẩu"
        ]);

        $passwordNewConfirm->addValidators([
            new PresenceOf(['message' => 'Mời bạn nhập mật khẩu']),
        ]);


        //form button submit
            $submit =new Submit(
                'submit',
                [
                    "value  " => "Submit",
                    "class" => "btn-md btn-theme float-left", 
                ]
            );

        $this->add($name);
        $this->add($email);
        $this->add($password);
        $this->add($passwordNewConfirm);
        $this->add($submit);

    }
}