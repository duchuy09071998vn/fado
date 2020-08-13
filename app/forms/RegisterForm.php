<?php
namespace App\Forms;

use Phalcon\Forms\Form;
use Phalcon\Forms\Element\Text;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Submit;
// Validation
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;

class RegisterForm extends Form
{
    public function initialize()
    {
        /**
         * Name
         */
        $name = new Text('name', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Enter Full Name"
        ]);

        // form name field validation
        $name->addValidator(
            new PresenceOf(['message' => 'The name is required'])
        );

        /**
         * Email Address
         */
        $email = new Text('email', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Enter Email Address"
        ]);

        // form email field validation
        $email->addValidators([
            new PresenceOf(['message' => 'Yêu cầu nhập email']),
            new Email(['message' => 'Email của bạn không hợp lệ']),
        ]);

        /**
         * New Password
         */
        $password = new Password('password', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Your Password"
        ]);

        $password->addValidators([
            new PresenceOf(['message' => 'Yêu cầu nhập password']),
            new StringLength(['min' => 5, 'message' => 'Password quá ngắn chưa đủ 5 kí tự']),
            new Confirmation(['with' => 'password_confirm', 'message' => 'Mật khẩu của bạn không khớp.']),
        ]);


        /**
         * Confirm Password
         */
        $passwordNewConfirm = new Password('password_confirm', [
            "class" => "form-control",
            // "required" => true,
            "placeholder" => "Confirm Password"
        ]);

        $passwordNewConfirm->addValidators([
            new PresenceOf(['message' => 'The confirmation password is required']),
        ]);


        /**
         * Submit Button
         */
        $submit = new Submit('submit', [
            "value" => "Register",
            "class" => "btn-md btn-theme float-left",
        ]);

        $this->add($name);
        $this->add($email);
        $this->add($password);
        $this->add($passwordNewConfirm);
        $this->add($submit);
    }
}