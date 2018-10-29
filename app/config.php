<?php
define('DS', DIRECTORY_SEPARATOR);

define('APP_PATH', rtrim(getcwd(), '/public'));

$urlParts = explode('www', APP_PATH)[1];
$urlParts = trim($urlParts, '\\');
$urlParts = explode('\\', $urlParts);
$urlPart = '';
foreach ($urlParts as $part) {
    $urlPart .= $part . DS;
}

define('URL', 'http://localhost' . DS . $urlPart . 'public' . DS);

define('LIBRARIES', APP_PATH . 'app' . DS . 'libraries' . DS);
define('CONTROLLERS', APP_PATH . 'app' . DS . 'controllers' . DS);
define('VIEWS', APP_PATH . 'app' . DS . 'views' . DS);
define('MODELS', APP_PATH . 'app' . DS . 'models' . DS);

define('DBTYPE', 'mysql');
define('DBHOST', 'localhost');
define('DBNAME', 'b2');
define('DBUSER', 'root');
define('DBPASSWORD', '');

// DO NOT CHANGE HASH_PASSWORD_KEY!

define('HASH_PASSWORD_KEY', 'dsjlk49t5jhrfenfer89r34ojire');

function __autoload($className) {
    require_once LIBRARIES . $className . '.class.php';
}