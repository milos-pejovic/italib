<?php
class Profile_model extends Model {
    
    /**
     * loadSingleUser - Loads information about a single user from the database.
     * 
     * @param boolean $session_store - Whether  to store the retreived data into session.
     * @return array - The data about the user.
     */
    
    public function loadSingleUser($session_store = false, $id = null, $profile_controller = 'profile') {
        
        if (gettype($profile_controller == 'string')) {
            require_once CONTROLLERS . 'Profile.php';
            $profile_controller = new Profile;
        }
        
        $data = [];
        $data['id'] = ($id == null) ? Session::get('id') : $id;
        
        if ($data['id'] === 'No entry') {
            $profile_controller->loadView('home/index');
            die;
        }

        $data = $this->db->selectOne('users', $data, PDO::FETCH_ASSOC);
        $adr = $this->db->selectOne('addresses', ['user_id' => $data['id']]);
        
        unset($data['password']);

        $adr = (array) $adr;
        $data = array_merge($adr, $data);
        
        if ($session_store) {
            Session::start();
            foreach($data as $key => $value) {
                Session::set($key, $value);
            }
        }
        return $data;
    }
    
    /**
     * saveChanges - Saves the changes made to a user's profile.
     * 
     * @param string, int - Id of the user whose data is changed.
     */
    
    public function saveChanges($user_id, $profile_controller) {
        $data = Validate::isFilled($_POST);
        $divided_data = Utility::splitAssocArr($data, ['street', 'number', 'city']);
        $address_data = $divided_data[1];
        $data = $divided_data[0];
        
        $this->db->update('users', $data, 'id = ' . $user_id);
        $this->db->update('addresses', $address_data, 'user_id = ' . $user_id);
        
        $data = $this->loadSingleUser($user_id);
        $address_data = $this->db->query('SELECT street, number, city FROM addresses WHERE user_id = ' . $user_id);
        $address_data = (array)$address_data[0];
        $res = array_merge($data, $address_data);
    
        $profile_controller->loadView('profile/index', $res);
    }
    
    /**
     * 
     * @param type $user_id
     */
    
    public function saveUserChanges($user_id, $profile_controller) {
        $data = Validate::isFilled($_POST);
        $divided_data = Utility::splitAssocArr($data, ['street', 'number', 'city']);
        $address_data = $divided_data[1];
        $data = $divided_data[0];
        
        $this->db->update('users', $data, 'id = ' . $user_id);
        $this->db->update('addresses', $address_data, 'user_id = ' . $user_id);
        $profile_controller->loadView('profile/membersSearchPage');
    }
    
    /**
     * saveNewPass - Saves new password
     * 
     * @param int, string $id - The id of the user whose password is changed
     */
    
    public function saveNewPass($id, $profile_controller) {
        $data = Validate::isFilled($_POST);

        $validatePasswords = Validate::passwordVal($data['newPass1'], $data['newPass2']);

        if ($validatePasswords) {
            Session::set('passwordChangeError', $validatePasswords);
            $profile_controller->loadView('profile/passChangeError');
            die;
        }
        
        $info = [];
        $info['password'] = Hash::create('sha256', $data['newPass1'], HASH_PASSWORD_KEY);
 
        $this->db->update('users', $info, 'id = ' . $id);
        
        $data = self::loadSingleUser(false, $id);
  
        $profile_controller->loadView('profile/index', $data);
    }
    
    /**
     * 
     * @return type
     */
    
    public function membersSearch($profile_controller) {
        $data = Validate::isFilled($_POST);
        $data = Utility::unsetEmptyArrayVals($data);

        $res = [];
        
        try {
            if ($data == []) {
                throw new Exception('Morate popuniti bar jedno polje.');
            } else 
            if (isset($data['membership_number']) && $data['membership_number'] != '') {
                $query = 'SELECT users.*, addresses.street, addresses.number, addresses.city
                    FROM users, addresses
                    WHERE users.id = addresses.user_id 
                    AND users.membership_number = :membership_number;';
                $query_data = [];
                $query_data['membership_number'] = $data['membership_number'];
                $res = $this->db->query($query, $query_data);

                if ($res) {
                    function unset_password($obj) {
                        unset($obj->password);
                    }
                    array_walk($res, 'unset_password');
                }
            } else {
                $query = 'SELECT users.*, addresses.street, addresses.number, addresses.city
                    FROM users, addresses
                    WHERE users.id = addresses.user_id 
                    AND ';

                foreach ($data as $key => $value) {
                    if ($key == 'street') {
                        $query .= ' addresses.street = :street AND ';
                    } else
                    if ($key == 'city') {
                        $query .= 'addresses.city = :city AND ';
                    } else {
                        $query .= "users.$key = :$key AND ";
                    }
                }

                $query = rtrim($query, ' AND ');
                $query .= ';';

                $res = $this->db->query($query, $data);
            }
        } catch (Exception $ex) {
            $profile_controller->loadView('profile/searchUserError', $ex->getMessage());
            die;
        }
 
    // Formating the results
        
        if ($res) {
            function formatData($obj) {
                $obj->address = $obj->street . ' ' . $obj->number;
                unset($obj->street);
                unset($obj->number);
                
                if ($obj->usertype == 'librarian') {
                    $obj->usertype = 'bibliotekar';
                } else if ($obj->usertype == 'member') {
                    $obj->usertype = '&#269;lan';
                } else {
                    $obj->usertype = '';
                }
            }
            array_walk($res, 'formatData');
        } 

        return $res;
    }
    
    /**
     * 
     * @param type $user_id
     * @return type
     */
    
    public function userDetails($user_id) {
        $user = $this->loadSingleUser(false, $user_id);

        $leased_books = $this->db->query(
            'SELECT leasing.*, books.title, copies.inventory_number 
            FROM leasing, books, copies 
            WHERE leasing.date_of_return is null
            AND leasing.copy_id = copies.copy_id
            AND copies.title = books.book_id
            AND member_id = '.$user['id'].';'
        );
        
        $data = [];
        $data['user_data'] = $user;
        $data['leased_books'] = $leased_books;

        return $data;
    }
}