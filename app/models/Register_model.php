<?php
class Register_model extends Model {

    /**
     * Functionality for entering a new user
     */
    
    public function registerUser($reg_ctrl) {
        $data = Validate::isFilled($_POST);

    // Password are checked    
        
        $validatePasswords = Validate::passwordVal($data['password1'], $data['password2']);

        if ($validatePasswords) {
            Session::set('registerPassErr', $validatePasswords);
            header('location:' . URL . 'register/registrationError');
            return;
        }

    // Encoding the password    
        
        $data['password'] = Hash::create('sha256', $data['password1'], HASH_PASSWORD_KEY);
        unset($data['password1']);
        unset($data['password2']);

    // Validating the membership number.    
        
        $validateMemNum = Validate::membershipNumberVal($data['membership_number']);
        
        if ($validateMemNum) {
            Session::set('registerPassErr', $validateMemNum);
            header('location:' . URL . 'register/registrationError');
            die;
        }
        
    // Entering the data into the database.
        
        $data = Utility::splitAssocArr($data, ['street', 'number', 'city']);

        $user_data = $data[0];
        $address_data = $data[1];
    
        $address_data['user_id'] = $this->db->insertFields('users', $user_data);

        $this->db->insertFields('addresses', $address_data);
        $reg_ctrl->loadView('register/userAdded');
    }
}