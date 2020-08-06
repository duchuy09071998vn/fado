<?php
use Phalcon\Mvc\Controller;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Http\Request;

//use form
use App\Forms\RegisterForm;

class SignupController extends ControllerBase
{
    public function indexAction()
    {
       $this->view->form =new RegisterForm();
    }

    public function registerAction()
    {
        $request = new Request();
        $user = new Users();
        $form = new RegisterForm();

        // check request
        if(!$this ->request->isPost())
        {
            return $this-> response ->redirect('signup/');
        }

        $form->bind($_POST, $user);
        // check form validation
        if (!$form->isValid())
        {
            foreach ($form->getMessages() as $message) 
            {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                [
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'index',
                ]);
                return;
            }
        }     
      
        $name =$this ->request ->getPost('name',['trim','string']);
        $email =$this ->request ->getPost('email',['trim','email']);
        $password =$this ->request ->getPost('password',['trim'],['password']);
        
        // Store and check for errors
        $success = $user->save(
            $this ->request ->getPost(),
            [
                "name",
                "email",
                "password"
            ]
        );

        // Lưu trữ mật khẩu và mã hóa
        $user->setPassword($this->security->hash($_POST['password']));

        if (!$user->save()) 
        {
            foreach ($user->getMessages() as $m)
            {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'index',
                ]);
                return;
            }            
        }
        $this->flashSession->success('Cảm ơn bạn đã đăng kí');
        return $this->response->redirect('user/login');

        $this->view->disable();              
    }
}

