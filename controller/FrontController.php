<?php
namespace App\controller;
use App\model\Manager;
use App\model\CharactersManager;
use App\model\charactersClass\Wizard;
use App\model\Fight;
session_start();

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
        $typeOfCharacter = $this->isPost('typeOfCharacter');
        $existingEnnemy = $this->isPost('existingEnnemy');
        $charactersManager = new CharactersManager($manager->dbConnect());
        if($newCharacterName && $newCharacterName != "") {
            $newCharacterName = htmlspecialchars($newCharacterName);
            $characterAlreadyExists = $charactersManager->checkCharacterExistence($newCharacterName);
            if(!$characterAlreadyExists){
                $classPath = "App\\model\\charactersClass\\" . ucfirst($typeOfCharacter);
                $newCharacter = new $classPath (['name' => $newCharacterName,]);
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
        } elseif($existingEnnemy && $existingEnnemy != "Choisissez..."){
            if($existingEnnemy == $chosenCharacter->id()){
                $errorMsg = "Tu ne peux pas te battre contre toi-même !";
            } else {
                $ennemyId = (int)$existingEnnemy;
                $chosenEnnemy = $charactersManager->getCharacter($ennemyId);
                $charactersManager->storeCharacterInSession('ennemy', $chosenEnnemy);
            }        
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if($existingEnnemy =='Choisissez...' && !$randomEnnemy){
                $errorMsg = "T'as oublié de choisir un ennemi !";
            }
        }

        $characters = $charactersManager->getList();
        $viewData = [
            'chosenCharacter' => $chosenCharacter,
            'characters' => $characters,
            'chosenEnnemy' => $chosenEnnemy,
            'errorMsg' => $errorMsg
        ];
        $this->render('homeView', $viewData);
    }
    public function fight() {
        $manager = new Manager;
        $fight = new Fight;
        $charactersManager = new CharactersManager($manager->dbConnect());
        $fleeSelected = $this->isPost("flee");
        $fleeMsg = null;
        $character = unserialize($_SESSION['character']);
        $ennemy = unserialize($_SESSION['ennemy']);
        $character->resetBonus();
        $ennemy->resetBonus();
        $character->resetMalus('criticalHit');
        $ennemy->resetMalus('criticalHit');
        $levelUpName = null;
        $userLose  = false;
        $userWin = false;
        $XPCharacter = $character->xp();
        $XPEnnemy = $ennemy->xp();
        $ennemyClass = $ennemy->getCharacterClass($ennemy);
        $characterClass = $character->getCharacterClass($character);

        if($fleeSelected){
            $fleeSuccess = $character->flee($character, $ennemy);
            if(!$fleeSuccess){
                if($characterClass == "Guerrier"){
                    [$HPCharacter, $damageCharacter] = $ennemy->hit($character, $ennemy);
                }else{
                    [$HPCharacter, $damageCharacter] = $ennemy->hit($character, $ennemy);
                }        
            }else{
                $fleeMsg = "Fuite réussie, fin du combat.";
                $fight->fleeFight($character, $ennemy);
                $fight->endFight($character, $ennemy, $levelUpName, $charactersManager);
                $charactersManager->updateCharacter($ennemy);
                $charactersManager->updateCharacter($character);
                header('Location: index.php');
            }
        }else{
            if($ennemyClass == "Guerrier"){
                [$HPEnnemy, $damageEnnemy] = $character->hit($ennemy, $character);    
            } else {
                [$HPEnnemy, $damageEnnemy] = $character->hit($ennemy, $character);
            }

            if($characterClass == "Guerrier"){
                [$HPCharacter, $damageCharacter] = $ennemy->hit($character, $ennemy);
            }else{
                [$HPCharacter, $damageCharacter] = $ennemy->hit($character, $ennemy);
            }

            if($ennemy->healthPoints() == 0 && $character->healthPoints() == 0){
                $charactersManager->deleteCharacter($character);
                $charactersManager->deleteCharacter($ennemy);
            }elseif($character->healthPoints() <= 0){
                $fight->winFight($ennemy, $HPEnnemy, $XPEnnemy);
                $userLose = true;
                $charactersManager->deleteCharacter($character);
            } elseif($ennemy->healthPoints() <= 0){
                $fight->winFight($character, $HPCharacter, $XPCharacter);
                $userWin = true;
                $charactersManager->deleteCharacter($ennemy);
            }

            if($userWin || $userLose){
                $charactersManager->updateCharacter($ennemy);
                $charactersManager->updateCharacter($character);
            }

            $charactersManager->storeCharacterInSession('character', $character);
            $charactersManager->storeCharacterInSession('ennemy', $ennemy);    
        }

        $viewData = [
            'HPEnnemy' => $HPEnnemy,
            'damageEnnemy' => $damageEnnemy,
            'character' => $character,
            'ennemy' => $ennemy,
            'HPCharacter' => $HPCharacter,
            'damageCharacter' => $damageCharacter,
            'levelUpName' => $levelUpName,
            'userLose' => $userLose,
            'userWin' => $userWin,
            'ennemyClass' => $ennemyClass,
            'characterClass' => $characterClass,
            'fleeMsg' => $fleeMsg
        ];
        $this->render('fightView', $viewData);
    }
}