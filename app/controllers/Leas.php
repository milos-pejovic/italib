<?php
class Leas extends Controller {
    
    public function index() {
        $this->loadView('leas/index');
    }
    
    public function enterLeas() {
        $this->model->enterLeas($this);
    }
    
    public function returnBookPage() {
        $this->loadView('leas/returnBookPage');
    }
    
    public function returnBook() {
        $this->model->returnBook($this);
    }
}