<?php
require_once('autoload.php');
use App\controller\FrontController;

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