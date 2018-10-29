<?php
class Session {
    
    /**
     * start - Starts a session.
     *         Get and Set methods already start a session if it does not exist
     */
    
    public static function start() {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
    
    /**
     * set - Creates a key-value pair in the session.
     *       If a session does not exists, it starts it first.
     * 
     * @param mixed $key - ...
     * @param mixed $value - ...
     * @param string $arr - ...
     */
    
    public static function set($key, $value, $arr = null) {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if ($arr == null) {
            $_SESSION[$key] = $value;
        } else {
            $_SESSION[$arr][$key] = $value;
        }
        
    }
    
    /**
     * get - Retrieves a key-value pair from the session.
     *       If a session does not exist, starts it first.
     *       Returns the user specifies value if the key does not exists.
     * 
     * @param mixes $key
     * @param string $default - Value to be returned if the key does not exist.
     * @return mixed
     */
    
    public static function get($key, $default = 'No entry', $arr = null) {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        if ($arr == null) {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
        } else {
            if (isset($_SESSION[$arr][$key])) {
                return $_SESSION[$arr][$key];
            }
        }
        
        return $default;
    }
    
    /**
     * destroy - Destroys the session.
     */
    
    public static function destroy() {
        if (isset($_SESSION)) {
            session_destroy();
        }
    }
    
    /**
     * 
     * @param type $data
     */
    
    public static function unsetExcept($data = []) {
        $newSession = [];
        foreach ($data as $key) {
            $newSession[$key] = isset($_SESSION[$key]) ? $_SESSION[$key] : null;
        }
        $_SESSION = $newSession;
    }
}