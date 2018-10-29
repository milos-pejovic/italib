<?php
class Validate {
   
    /**
     * isFilled - Conducts security check on each entry in an array and returns
     *            cleaned data.
     * 
     * @param array $array - Array whose values are to be checked.
     * @return array - Return cleaned data.
     */
    
    public static function isFilled($array) {
        $data = [];
        foreach($array as $key => $value) {
            if ($array[$key] === '') {
                $data[$key] = '';
                continue;
            }
            $data[$key] = Security::cleanString($array[$key]);
        }
        return $data;
    }
    
    /**
     * digit - Checks if a string consits of digits.
     *         If it does not, returns a message.
     * 
     * @param string $data - String to be checked
     * @return null, string - Error message or nothing.
     */
    
    public static function digit($data) {
        if (ctype_digit($data) == false) {
            return 'Unos ' . $data . ' se mora sastojati samo od brojeva.';
        }
    }
    
    /**
     * validatePasswords - Checks password entries against specified criteria.
     *                     Criteria:
     *                          Password must be at least 5 characters long.
     *                          Two entries must be identical.
     *                          Password must not already exists in the database.
     *                     If entries do not match the criteria, returns an error message.
     * 
     * @param string $pass1 - First password entry.
     * @param string $pass2 - Second password entry.
     * @return string, null - Error message or nothing.
     */
    
    public static function passwordVal($pass1, $pass2) {  
        if (strlen($pass1) < 5) {
            return '&#352;ifra mora imati bar 5 karaktera.';
        }
        
        if ($pass1 !== $pass2) {
            return 'Unete &#353;ifre moraju biti identi&#269;ne.';
        }
        
        $pass = Hash::create('sha256', $pass1, HASH_PASSWORD_KEY);
        $data = [];
        $data['password'] = $pass;
        
        $db = new Database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASSWORD);
        
        $res = $db->selectOne('users', $data);
        
        if ($res) {
            return '&#352;ifra vec postoji.<br />Molimo izaberite drugu &#353;ifru';
        }
        
        return null;
    }
    
    /**
     * membershipNumberVal - Validates the membership number against specified criteria.
     *                       Criteria:
     *                          The number must consist only of digits.
     *                          The number must contain exactly 7 digits.
     *                          The number must already exist in the database.
     *                       If the membership number does not match the criteria, reutrns an error message.
     * 
     * @param int, string $num - 
     * @return string, null
     */
    
    public static function membershipNumberVal($num) {
        if (ctype_digit($num) == false) {
            return '&#268;lanski broj se mora sastojati samo od cifara.';
        }
        
        if (strlen($num) != 7) {
            return '&#268;lanski broj mora imati ta&#269;no 7 cifara.';
        }
 
        $data = [];
        $data['membership_number'] = $num;
        
        $db = new Database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASSWORD);
        $res = $db->selectOne('users', $data);
        
        if ($res) {
            return '&#268;lanski broj je ve&#263; upotrebljen.<br />Molimo izaberite drugi &#269;lanski broj.';
        }
        
        return null;
    }
    
    /**
     * validateBook - Validates the data necessary to add a book into the database.
     *                All the fields (except the authors' names) are checked if they are empty.
     *                  If they are, an error message is returned.
     *                  If not, script goes on.
     *                A check is made to see if the inventory number already exists.
     *                  If yes, an error message is returned.
     *                  If not, the script goes on.
     *                If an error message has not been returned by now, null is returned.
     * 
     * @param array $title - Data about the book in general.
     * @param array $book - Data about the specific copy of the book.
     * @param array $authors - Data about the authors of the book.
     * @return string, null - Error message or null
     */
    
    // Currently there is no check regarding the names of the authors. In this way
    // it is possible to add a book at one time, and add the authors later.
    
    public static function validateBook($title, $book, $authors) {
        $fields = [
            'title' => 'naziv knjige',
            'UDC' => 'UDK broj',
            'ISBN' => 'ISBN broj',
            'inventory_number' => 'inventarni broj'
        ];
        
        $data = array_merge($title, $book);

        foreach ($data as $key => $value) {
            if ($value == '') {
                return 'Morate uneti ' . $fields[$key] . '.';
            }
        }
        
    // Checking if the inventory number already exists in the database.   
        
        $db = new Database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASSWORD);
        $res = $db->query('SELECT * FROM copies WHERE inventory_number = ' . 
                $book['inventory_number']);
        if ($res) {
             return 'Uneti inventarni broj postoji u bazi, molimo izaberite drugi.';
        }
        
        return null;
    }
    
    /**
     * 
     * @param type $data
     */
    
    public static function searchByAuthorsData($data) {
        
        if (gettype($data) === 'array') {
            $data = implode(' ', $data);
        }
        
        $data = Security::cleanString($data);
        $data = str_replace(',', ' ', $data);
        $data = preg_replace('/\s+/', ' ', $data);
        $data = explode(' ', $data);

        $data2 = [];
        foreach($data as $item) {
            $item = '"' . $item . '",';
            array_push($data2, $item);
        }
        
        $data2 = implode(' ', $data2);
        $data2 = rtrim($data2, ',');
        
        return $data2;
    }
}