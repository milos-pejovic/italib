<?php
class Login_model extends Model {
    
    /**
     * checkIdentity - Checks the identity of the user trying to log in
     * 
     * @return boolean
     */

    public function checkIdentity($index_controller) {
        $data = Validate::isFilled($_POST);
 
        $data['password'] = Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY);
        $result = $this->db->selectOne('users', $data);

        $page = '';
        
        if ($result == null) {
            Session::set('loggingError', true);
            $index_controller->loadView('login/index');
        } else {
            Session::set('loggingError', false);
            Session::set('loggedIn', true);
            Session::set('id', $result->id);
            Session::set('usertype', $result->usertype);

            $index_controller->loadView('home/index');
        }
    } 
    
    /**
     * logout - Logs out a user.
     */
    
    public function logout($index_controller) {
        Session::start();
        Session::destroy();
        unset($_SESSION);
        $index_controller->loadView('home/index');
    }
}