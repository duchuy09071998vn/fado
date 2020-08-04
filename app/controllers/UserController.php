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

    //Login Page View
     
    public function loginAction()
    {

        // Login Form
        $this->view->form = new LoginForm();
    }

   
    public function loginSubmitAction()
    {
        $user = new Users;
        $form =new LoginForm();

        // check request
        if (!$this->request->isPost()) {
            return $this->response->redirect('user/login');
        }
        $form->bind($_POST, $user);
        // check form validation
        if (!$form->isValid()) {
            foreach ($form->getMessages() as $message) {
                $this->flashSession->error($message);
                $this->dispatcher->forward([
                    'controller' => $this->router->getControllerName(),
                    'action'     => 'index',
                ]);
                return;
            }
        }

        $user ->setPassword($this->security->hash($_POST['password']));
        // login with database
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
    }
}
