<?php
use Phalcon\Http\Request;

// use form
use App\Forms\RegisterForm;
use App\Forms\LoginForm;

class UserController extends ControllerBase
{
    public $loginForm;
    public $usersModel;

    public function onConstruct()
    {
    }

    public function initialize()
    {
        $this->loginForm = new LoginForm();
        $this->usersModel = new Users();
    }

    public function loginAction()
    {
       
        // Login Form
        $this->view->form = new LoginForm();
    }

    public function loginSubmitAction()
    {
        // check request
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/login');
        }

        $this->loginForm->bind($_POST, $this->usersModel);
        
        // check form validation
        if (!$this->loginForm->isValid()) {
            foreach ($this->loginForm->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'login',
                ]);
                return;
            }
        }
        
        // Login with database
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $user = Users::findFirst([ 
            'email = :email:',
            'bind' => [
               'email' => $email,
            ]
        ]);
        
        if ($user) {
            if ($this->security->checkHash($password, $user->password))
            {
                 // Set a session
                $this->session->set('AUTH_ID', $user->id);
                $this->session->set('AUTH_NAME', $user->name);
                $this->session->set('AUTH_EMAIL', $user->email);
                //$this->session->set('AUTH_CREATED', $user->created);
                //$this->session->set('AUTH_UPDATED', $user->updated);
                $this->session->set('IS_LOGIN', 1);

                return $this->response->redirect('user/profile');
            }
        } else {
            $this->security->hash(rand());
        }

        $this->flashSession->error("Mật khẩu của bạn không đúng");
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

