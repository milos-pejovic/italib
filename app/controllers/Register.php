<?php
class Register extends Controller {

    public function index() {
        $this->checkLog();
        $this->checkLib();
        if (isset($_SESSION)) {
            Session::unsetExcept(['loggedIn', 'usertype', 'id']);
        }
        $this->loadView('register/index');
    }
    
    public function registerUser() {
        $this->checkLog();
        $this->checkLib();
        $this->model->registerUser($this);
    }
    
    public function registrationError() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('register/registrationError');
    }
}