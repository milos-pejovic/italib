<?php
class Home extends Controller {
    
    public function index() {
        $this->loadView('home/index');
    }
    
}