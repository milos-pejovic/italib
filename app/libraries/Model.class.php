<?php

/**
 * Main model functionality.
 * This class is extended by all models.
 */

class Model {
    
    /**
     * __construct - Creates $db property which is an instance of Database class.
     *               Database extends PDO so $db is a PDO object. 
     */
    
    function __construct() {
        $this->db = new Database(DBTYPE, DBHOST, DBNAME, DBUSER, DBPASSWORD);
    }
}