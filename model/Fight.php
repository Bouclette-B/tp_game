<?php
namespace App\model;
class Fight {
    public function winFight(Character $character, $HPCharacter, $XPCharacter){
        $HPCharacter = (int)$HPCharacter + 50;
        $XPCharacter += 25;
        $character->setXp($XPCharacter);
        $character->setHealthPoints($HPCharacter);
    }

    public function fleeFight(Character $character, Character $ennemy){
        $XPCharacter = $character->xp() + 10;
        $HPCharacter = $character->healthPoints() + 10;
        $XPEnnemy = $ennemy->xp() + 10;
        $HPEnnemy = $ennemy->healthPoints + 10;
        $character->setXp($XPCharacter);
        $character->setHealthPoints($HPCharacter);
        $ennemy->setXp($XPEnnemy);
        $ennemy->setHealthPoints($healthPoints);
    }

    public function endFight(Character $character, Character $ennemy, $levelUpName){
        if($character->xp() == 100){
            $levelUpName = $character->levelUp($character);
        }elseif($ennemy->xp() == 100) {
            $levelUpName = $ennemy->levelUp($ennemy);
        }
    }

}