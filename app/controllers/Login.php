<?php
class Login extends Controller {
    
    public function index() {
        $this->loadView('login/index');
    }
    
    public function checkIdentity() {
        $this->model->checkIdentity($this);
    }
    
    public function logout() {
        $this->model->logout($this);
    }
}