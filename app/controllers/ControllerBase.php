<?php

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
    public function onConstruct()
    {
        date_default_timezone_set('Asia/Calcutta'); // India Timezone
    }

    public function authorized()
    {
        if (!$this->isLoggedIn()) 
        {
            return $this->response->redirect('user/login');
        }
    }

    public function isLoggedIn()
    {
        // Check if the variable is defined
        if ($this->session->has('AUTH_NAME') AND $this->session->has('AUTH_EMAIL')) 
        {
            return true;
        }
        return false;
    }
}
