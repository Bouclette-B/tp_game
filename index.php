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



// $manager = new Manager;
// $charactersManager = new CharactersManager($manager->dbConnect());

// $charactersList = $charactersManager->getList('Oceane');
// foreach($charactersList as $characterInfo){
//     echo $characterInfo->name() . '<br />';
// }

// $Juju = new Character(['name' => 'Juju']);
// $charactersManager->addCharacter($Juju);

// $Océane = new Character(['name' => 'Océane']);
// $charactersManager->addCharacter($Océane);

// $count = $charactersManager->countCharacters();
// echo "Il y a " . $count . " personnages.";

//$charactersManager->deleteCharacter($Juju);

//$charactersManager->checkCharacterExistence(5);
// $Juju = $charactersManager->getCharacter(2);
// $Kevin = $charactersManager->getCharacter(1);

// $Juju->hit($Kevin, $Juju->name(), $Kevin->name());
// $charactersManager->updateCharacter($Kevin);

// $Kevin->hit($Juju, $Kevin->name(), $Juju->name());
// $charactersManager->updateCharacter($Juju);
