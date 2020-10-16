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
                $charactersManager->storeCharacterInSession('character', $chosenCharacter);
            }
        } elseif($existingCharacter){
            $characterId = (int)$existingCharacter;
            $chosenCharacter = $charactersManager->getCharacter($characterId);
            $charactersManager->storeCharacterInSession('character', $chosenCharacter);
        }
        
        if($randomEnnemy) {
                $idList = $charactersManager->getIdList($chosenCharacter->id());
                $ids = [];
                foreach($idList as $id){
                    $id = array_flip($id);
                    $ids += $id;
                }
                $randomId = array_rand($ids, 1);
                $chosenEnnemy = $charactersManager->getCharacter((int)$randomId);
                $charactersManager->storeCharacterInSession('ennemy', $chosenEnnemy);
        } elseif($existingEnnemy){
            if($existingEnnemy == $chosenCharacter->id()){
                $errorMsg = "Tu ne peux pas te battre contre toi-même !";
            } else {
                $ennemyId = (int)$existingEnnemy;
                $chosenEnnemy = $charactersManager->getCharacter($ennemyId);
                $charactersManager->storeCharacterInSession('ennemy', $chosenEnnemy);
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
        $manager = new Manager;
        $charactersManager = new CharactersManager($manager->dbConnect());
        $storeCharacter = unserialize($_SESSION['character']);
        $character = $charactersManager->getCharacter($storeCharacter->id());
        $storeEnnemy = unserialize($_SESSION['ennemy']);
        $ennemy = $charactersManager->getCharacter($storeEnnemy->id());
        $characterisDead = false;
        $ennemyIsDead = false;
        [$HPEnnemy, $damageEnnemy] = $character->hit($ennemy);
        [$HPCharacter, $damageCharacter] = $ennemy->hit($character);
        if($ennemy->healthPoints() == 0 && $character->healthPoints() == 0){
            $charactersManager->deleteCharacter($character);
            $charactersManager->deleteCharacter($ennemy);
        }elseif($character->healthPoints() <= 0){
            $characterisDead = true;
            $charactersManager->deleteCharacter($character);
        } elseif($ennemy->healthPoints() <= 0){
            $ennemyIsDead = true;
            $HPCharacter = (int)$HPCharacter + 50;
            $character->setHealthPoints($HPCharacter);
            $charactersManager->deleteCharacter($ennemy);
        }
        $charactersManager->updateCharacter($ennemy);
        $charactersManager->updateCharacter($character);

        $viewData = [
            'HPEnnemy' => $HPEnnemy,
            'damageEnnemy' => $damageEnnemy,
            'character' => $character,
            'ennemy' => $ennemy,
            'HPCharacter' => $HPCharacter,
            'damageCharacter' => $damageCharacter,
            'characterisDead' => $characterisDead,
            'ennemyIsDead' => $ennemyIsDead

        ];
        $this->render('fightView', $viewData);
    }
}