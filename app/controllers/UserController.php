<?php
use Phalcon\Http\Request;

// use form
use App\Forms\RegisterForm;
use App\Forms\LoginForm;

class UserController extends ControllerBase
{
    public $loginForm;
    public $usersModel;

    public function initialize()
    {
        $this->loginForm = new LoginForm();
        $this->usersModel = new Users();
    }

    //Login Page View   
    public function loginAction()
    {
        // Login Form
        $this->view->form = new LoginForm();
    }

   
    //Login SubmitAction
    public function loginSubmitAction()
    {

        // check request
        if (!$this->request->isPost()) 
        {
            return $this->response->redirect('user/login');
        }

        // Validate CSRF token
        if(!$this->security->checkTolen())
        {
            $this->flashSession ->error("Mã không hợp lệ");
            return $this ->response ->redirect('user/login');
        }

        $form->bind($_POST, $user);

        // check form validation
        if (!$form->isValid()) 
        {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward(
                [
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'login',
                ]);
                return;
            }
        }

        // login with database
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = Users::findFirst(
        [ 
            'email = :email:',
            'bind' => 
            [
               'email' => $email,
            ]
        ]
        );

        
        if($user)
        {
            if ($this->security->checkHash($password, $user->password))
            {               
                // Set a session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_EMAIL', $user->email);
                $this->session->set('IS_LOGIN', 1);
                
                // The password is valid
                $this->flashSession->success("Đăng nhập thành công");
                return $this->response->redirect('user/profile');
            }
        } else
        {           
            $this->security->hash(rand());
        }

        // The validation has failed   
        $this->flashSession->error("Đăng nhập không hợp lệ");
        return $this->response->redirect('user/login'); 
    }


    // Use Profile
    public function profileAction()
    {
        $this->authorized();
    }
    
}
