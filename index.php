<?php
function loadClass($class){
    require './model/' . $class . '.php';
}
spl_autoload_register('loadClass');
require('./controller/FrontController.php');
$frontController = new FrontController;

$action = (isset($_GET['action'])) ? $_GET['action'] : NULL;
try {
    switch($action) {
        case 'fight' :
            $frontController->fight();
            break;
        default :
            $frontController->home();
    }
}
catch(Exception $e) {
    die('Erreur : ' . $e->getMessage());
}