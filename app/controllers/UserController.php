<?php
use Phalcon\Mvc\Controller;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Http\Request;
// use form
use App\Forms\LoginForm;
class UserController extends ControllerBase
{
    //Login Page View   
    public function loginAction()
    {
        $this->view->form = new LoginForm();   

    }

    //Login SubmitAction
    public function loginSubmitAction()
    {
        $user =new Users();
        $form =new LoginForm();
        // check request
        if (!$this->request->isPost()) 
        {
            return $this->response->redirect('user/login');    
        }     
        $form->bind($_POST, $user);

        // check form validation
        if(!$form ->isVaild())
        {
            foreach ($form->getMessages() as $message)
            {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                [
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'login',
                ]);
                return;
            }
        }

        // Login with databaste
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = Users::findFirst(
        [ 
            'email = :email:',
            'bind' => 
            [
            'email' => $email,
            ]
        ]);
        if ($user) 
        {
            if ($this->security->checkHash($password, $user->password))
            {
               
                // Set a session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_EMAIL', $user->email);  
                $this->session->set('IS_LOGIN', );     
                

                //$this->flashSession->success("Đăng nhập thành công");
                return $this->response->redirect('user/profile');
            }
        } else
        {
            $this->security->hash(rand());
        }

         // The validation has failed
         $this->flashSession->error("Đăng nhập thất bại");
         return $this->response->redirect('user/login');

    }

    public function profileAction() 
    {
        $this->authorized();
    }

    public function logoutAction()
    {
        // Destroy the whole session
        $this->session->destroy();
        return $this->response->redirect('user/login');
    }
    
    
}


