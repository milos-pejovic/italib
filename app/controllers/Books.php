<?php
class Books extends Controller {

    public function index() {
        $this->checkLog();
        $this->checkLib();
        if (isset($_SESSION)) {
            Session::unsetExcept(['loggedIn', 'usertype', 'id']);
        }
        $this->loadView('books/index');
    }
    
    public function AddBookForm($num) {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('books/addBookForm', $num);
    }
    
    public function processNumAuth() {
        $this->checkLog();
        $this->checkLib();
        $num = $this->model->processNumAuth();
        $this->loadView('books/addBookForm', $num);
    }
    
    public function numberOfAuthors() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('books/number_of_authors');
    }

    public function addBook($number_of_authors) {
        $this->checkLog();
        $this->checkLib();
        $this->model->addBook($this, $number_of_authors);
    }
    
    public function bookEntryError() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('books/bookEntryError');
    }
    
    public function bookSearch() {
        $this->checkLog();
        $this->checkLib();
        $books = $this->model->bookSearch($this);
        $this->loadView('books/index', $books);
    }
    
    public function editBookPage($book_id) {
        $this->checkLog();
        $this->checkLib();
        $book = $this->model->bookSearch($this, $book_id)[0];
        $this->loadView('books/editBookPage', $book);
    }
    
    public function editBookSave($book_id) {
        $this->checkLog();
        $this->checkLib();
        $this->model->editBookSave($this, $book_id);
    }

    public function editAuthorsPage($book_id, $title) {
        $this->checkLog();
        $this->checkLib();
        $data = $this->model->loadAuthors($book_id);
        $this->loadView('books/editAuthorsPage', $data);
    }
    
    public function saveAuthorChange($book_id) {
        $this->checkLog();
        $this->checkLib();
        $this->model->saveAuthorChange($book_id, $this);
    }
    
    public function addAuthorsNumber($book_id) {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('books/addAuthorsNumber', $book_id);
    }
    
    public function addAuthors() {
        $this->checkLog();
        $this->checkLib();
        $this->model->addAuthors($this);
    }
    
    public function addAuthorsSave($book_id) {
        $this->checkLog();
        $this->checkLib();
        $this->model->addAuthorsSave($this, $book_id);
    }
    
    public function copies($book_id) {
        $this->checkLog();
        $this->checkLib();
        $copies = $this->model->copies($book_id);
        $this->loadView('books/copiesPage', $copies);
    }
}