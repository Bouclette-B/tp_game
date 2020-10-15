<?php
session_start();

require_once('./controller/BackController.php');
require_once('./model/Manager.php');
class FrontController extends BackController
{
    public function home() {
        $newCharacterName = $this->isPost('newCharacter');
        $existingCharacter = $this->isPost('existingCharacter');
        $manager = new Manager;
        $chosenCharacter = null;
        $chosenEnnemy = null;
        $errorMsg = null;
        $randomEnnemy = $this->isPost('randomEnnemy');
        $existingEnnemy = $this->isPost('existingEnnemy');
        $charactersManager = new CharactersManager($manager->dbConnect());
        if($newCharacterName && $newCharacterName != "") {
            $newCharacterName = htmlspecialchars($newCharacterName);
            $characterAlreadyExists = $charactersManager->checkCharacterExistence($newCharacterName);
            if(!$characterAlreadyExists){
                $newCharacter = new Character(['name' => $newCharacterName]);
                $charactersManager->addCharacter($newCharacter);
                $chosenCharacter = $charactersManager->getCharacter($newCharacterName);
                $_SESSION['characterName'] = $chosenCharacter->name();
                $_SESSION['characterId'] = $chosenCharacter->id();
                $_SESSION['characterHP'] = $chosenCharacter->healthPoints();
            }
        } elseif($existingCharacter){
            $characterId = (int)$existingCharacter;
            $chosenCharacter = $charactersManager->getCharacter($characterId);
            $_SESSION['characterName'] = $chosenCharacter->name();
            $_SESSION['characterId'] = $chosenCharacter->id();
            $_SESSION['characterHP'] = $chosenCharacter->healthPoints();        
        }
        
        if($randomEnnemy) {
                $idList = $charactersManager->getIdList($_SESSION['characterId']);
                $ids = [];
                foreach($idList as $id){
                    $id = array_flip($id);
                    $ids += $id;
                }
                $randomId = array_rand($ids, 1);
                $chosenEnnemy = $charactersManager->getCharacter((int)$randomId);
                $_SESSION['ennemyName'] = $chosenEnnemy->name();
        } elseif($existingEnnemy){
            if($existingEnnemy == $chosenCharacter->id()){
                $errorMsg = "Tu ne peux pas te battre contre toi-même !";
            } else {
                $ennemyId = (int)$existingEnnemy;
                $chosenEnnemy = $charactersManager->getCharacter($ennemyId);
                $_SESSION['ennemyName'] = $chosenEnnemy->name();
                $_SESSION['ennemyId'] = $chosenEnnemy->id();
                $_SESSION['ennemyHP'] = $chosenEnnemy->healthPoints();
            }        
        }

        $characters = $charactersManager->getList();
        $viewData = [
            'chosenCharacter' => $chosenCharacter,
            'characters' => $characters,
            'newCharacterName' => $newCharacterName,
            'chosenEnnemy' => $chosenEnnemy,
            'errorMsg' => $errorMsg
        ];
        $this->render('homeView', $viewData);
    }
    public function fight() {
        
        echo "Battez-vous !";
    }
}