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
            return $this-> response ->redirect('signup');
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
        
        /* $user->setPassword($this->security->hash($_POST['password']));

        $user->setActive(1);
        $user->setCreated(time());
        $user->setUpdated(time());
        if (!$user->save()) {
            foreach ($user->getMessages() as $m) {
                $this->flashSession->error($m);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'register',
                ]);
                return;
            }
        } */


        #$params = $this ->request ->getPost();

        #$name = !empty($params['name'])?trim($params['name']):'';

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

        if ($success) {
             // Direct Flash Message
            $this->flash->success('Cảm ơn bạn đã đăng kí thành công');

        } else {
            echo "Xin lỗi, bạn chưa đăng kí thành công: ";

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message->getMessage(), "<br/>";
            }
        }

        $this->view->disable();

    }
}

