<?php

/**
 * Main controller. Every controller extends it.
 */

class Controller {
    
    /**
     * checkLog - Checks if the user is logged in.
     *            If yes, the rest of the script goes on as normal.
     *            If not, calls 'home/index' page which is the defualt
     *            behaviour when wrong url is entered within the page.
     */
    
    public function checkLog() {
        $logged = Session::get('loggedIn');
        if (!$logged) {
            header('location:' . URL . 'home');
        }
    }
    
    /**
     * checkLib - Checks if the current user is a librarian.
     *            If yes, the rest of the script goes on as normal.
     *            If not, calls 'home/index' page which is the defualt
     *            behaviour when wrong url is entered within the page.
     */
    
    public static function checkLib() {
        $lib = Session::get('usertype');
        if (!$lib) {
            header('location:' . URL . 'home');
        }
    }
    
    /**
     * loadview - Loads the specified view.
     * 
     * @param string $viewName - Which view to load.
     * @param array $data - Data created by model.
     */
    
    public function loadView($viewName, $data = []) {
        require_once VIEWS . 'header.php';
        require_once VIEWS . $viewName . '.php';
        require_once VIEWS . 'footer.php';
    }
    
}