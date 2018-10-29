<?php

/**
 * Extends PDO.
 * Defines the main functionalities for working with database.
 * Database class is instantiated in Model class which is extended by all models.  
 */

class Database extends PDO {
    
    /**
     * __construct - Used to instantiate PDO 
     * 
     * @param constant $DBTYPE - Type of the RDBMS.
     * @param constant $DBHOST - Hostname.
     * @param constant $DBNAME - Name of the database.
     * @param constant $DBUSER - Name of the user.
     * @param constant $DBPASSWORD - User password.
     */
    
    function __construct($DBTYPE, $DBHOST, $DBNAME, $DBUSER, $DBPASSWORD) {
        parent::__construct($DBTYPE . ':host=' . $DBHOST . ';dbname=' . $DBNAME, $DBUSER, $DBPASSWORD);
    }
    
    /**
     * query - Executes a whole query passed as as string.
     * 
     * @param string $query - The query to be executed.
     * @param array $data - Data to be entered into the query
     * @param constant $fetchMode - The fetch mode for return value.
     * @return array - Data retrieved from database.
     */
    
    public function query($query, $data = [], $fetchMode = PDO::FETCH_OBJ) {
        $stat = $this->prepare($query);
 
        if ($data) {
            foreach ($data as $key => $value) {
                $stat->bindValue(":$key", $value);
            }
        }
        
        $stat->execute();
        return $stat->fetchAll($fetchMode);
    }
    
    /**
     * insertFields - Insert data into a table using only specified fields.
     * 
     * @param string $table - Table into which to insert data. 
     * @param array $data - Data to insert.
     * @return string - Last inserted id.
     */
    
    public function insertFields($table, $data) {
        $fieldNames = '';
        $fieldValues = '';
        
        foreach($data as $key => $value) {
            $fieldNames .= $key . ', ';
            $fieldValues .= ':' . $key . ', ';
        }

        $fieldNames = rtrim($fieldNames , ', ');
        $fieldValues = rtrim($fieldValues , ', ');

        $stat = $this->prepare('INSERT INTO ' . $table . ' (' . $fieldNames . ')' . ' VALUES (' . $fieldValues . ');');

        foreach($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }
 
        $stat->execute();
        return $this->lastInsertId();
    }
    
    /**
     * Insert - Inserts data into a table
     * 
     * @param string $table - Table in which to insert data.
     * @param array $data - Data to insert.
     */
    
    public function insert($table, $data = []) {
        $values = 'null, ';
        foreach ($data as $key => $value) {
            $values .= ":$key, ";
        }
        $values = rtrim($values, ', ');
 
        $stat = $this->prepare('INSERT INTO ' . $table . ' VALUES (' . $values . ');');
        
        foreach ($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }
 
        $stat->execute();
        return $this->lastInsertId();
    }
    
    /**
     * selectOne - Selects one entry from a table
     * 
     * @param string $table - Table from which to select an entry.
     * @param array $data - Parameters from which to build WHERE query part.
     * @param constant $fetchMode - The fetch mode for return value.
     * @return object - Entry retreived from the table.
     */
    
    public function selectOne($table, $data, $fetchMode = PDO::FETCH_OBJ) {
        $where = '';
        foreach ($data as $key => $value) {
            $where .= $key . ' = :' . $key . ' AND ';
        }

        $where = rtrim($where, ' AND ');

        $stat = $this->prepare('SELECT * FROM ' . $table . ' WHERE ' . $where . ';');
        foreach ($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }

        $stat->execute();
        return $stat->fetch($fetchMode);
    }

    /**
     * selectSome - Selects some of the entries from a table
     * 
     * @param string $table - The table to retreive data from.
     * @param array $data - Parameters for building the WHERE query part.
     * @param string $what - Columns from which to retreive data.
     * @param constant $fetchMode - fetch mode for the return value.
     * @return array - Entries retrieved from the table.
     */
    
    public function selectSome($table, $data, $what = '*', $fetchMode = PDO::FETCH_OBJ) {
        $where = '';
        foreach ($data as $key => $value) {
            $where .= $key . ' = :' . $key . ' AND ';
        }
        $where = rtrim($where, ' AND ');

        $stat = $this->prepare('SELECT ' . $what . ' FROM ' .$table . ' WHERE ' . $where . ';');

        foreach ($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }
        $stat->execute();
        return $stat->fetchAll($fetchMode);
    }
    
    /**
     * selectAll - Selects all entries from a table
     * 
     * @param string $table - Table from which to retreive data.
     * @param string $what - Columns from which to retreive data.
     * @param constant $fetchMode - The fetch mode for the return value.
     * @return array - Data retrieved from the table.
     */
    
    public function selectAll($table, $what = '*', $fetchMode = PDO::FETCH_OBJ) {
        $stat = $this->query('SELECT ' . $what . ' FROM ' . $table);
        return $stat->fetchAll($fetchMode);
    }
    
    /**
     * delete - Deletes one or more entries from a table.
     * 
     * @param string $table - Table from which to delete an entry.
     * @param array $data - Parameters from which to build WHERE query part.
     * @param int, string $limit - Maximum number of entries to be deleted.
     */

    public function delete($table, $data, $limit = '1') {
        $where = '';
        foreach ($data as $key => $value) {
            $where .= $key . ' = :' . $key . ' AND ';
        }
        $where = rtrim($where, ' AND ');
        
        $stat = $this->prepare('DELETE FROM ' . $table . ' WHERE ' . $where . ' LIMIT ' . $limit . ';');
        foreach ($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }
        $stat->execute();
    }
    
    /**
     * update - Updates data in a table.
     * 
     * @param string $table - Table in which to update data.
     * @param array $data - Updates to be made
     * @param string $where - Specifies the row(s) where the updates should be made  
     */
    
    public function update($table, $data, $where) {
        $changes = '';
        foreach ($data as $key => $value) {
            $changes .= $key .  ' = :' . $key . ', ';
        }

        $changes = rtrim($changes, ', ');
        
        $stat = $this->prepare('UPDATE ' . $table . ' SET ' . $changes . ' WHERE ' . $where . ';');

        foreach ($data as $key => $value) {
            $stat->bindValue(":$key", $value);
        }

        $stat->execute();
    }
}