<?php

use Phalcon\Mvc\Model;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Uniqueness as Uniqueness;

class Users extends Model
{
    public $id;
    public $name;
    public $email;
    public $password;


    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function getPassword()
    {
        return $this->password;
    }

    // Kiểm tra email tồn tại
    public function validation()
    {
        $validator = new Validation();

        $validator->add(
            'email',
            new EmailValidator(
                [
                    'model'   => $this,
                    'message' => 'Nhập địa chỉ email chính xác',
                ]
            )
        );

        $validator->add(
            'email',
            new Uniqueness(
                [
                    'model'   => $this,
                    'message' => 'Địa chỉ email này đã tồn tại',
                    'cancelOnFail' => true,
                ]
            )
        );

        return $this->validate($validator);
    }
    
    public function columnMap()
    {
        return [
            'id' => 'id',
            'name' => 'name',
            'email' => 'email',
            'password' => 'password',           
        ];
    }

}   