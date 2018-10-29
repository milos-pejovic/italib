<?php
class Profile extends Controller {
    
    public function index() {
        $this->checkLog();
        if (isset($_SESSION)) {
            Session::unsetExcept(['loggedIn', 'usertype', 'id']);
        }
        $user = $this->model->loadSingleUser(false, null, $this);
        $this->loadView('profile/index', $user);
    }
    
    public function change() {
        $this->checkLog();
        $user = $this->model->loadSingleUser(true);
        $this->loadView('profile/change', $user);
    }
    
    public function saveChanges($id) {
        $this->checkLog();
        $this->model->saveChanges($id, $this);
    }
    
    public function changePassword($id) {
        $this->checkLog();
        $this->loadView('profile/changePassword', $id);
    }
    
    public function saveNewPass($id) {
        $this->checkLog();
        $this->model->saveNewPass($id, $this);
    }
    
    public function passChangeError() {
        $this->checkLog();
        $this->loadView('profile/passChangeError');
    }
    
    public function membersSearchPage() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('profile/membersSearchPage');
    }
    
    public function membersSearch() {
        $this->checkLog();
        $this->checkLib();
        $members = $this->model->membersSearch($this);
        $this->loadView('profile/membersSearchPage', $members);
    }
    
    public function changeUserData($user_id) {
        $this->checkLog();
        $this->checkLib();
        $user = $this->model->loadSingleUser(false, $user_id);
        $this->loadView('profile/changeUserData', $user);
    }
    
    public function saveUserChanges($user_id) {
        $this->checkLog();
        $this->checkLib();
        $this->model->saveUserChanges($user_id, $this);
    }
    
    public function userDetails($user_id) {
        $this->checkLog();
        $this->checkLib();
        $data = $this->model->userDetails($user_id);
        $this->loadView('profile/userDetailsPage', $data);
    }
}