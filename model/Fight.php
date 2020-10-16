<?php
class Fight {
    public function winFight(Character $character, $HPCharacter, $XPCharacter){
        $HPCharacter = (int)$HPCharacter + 50;
        $XPCharacter += 25;
        $character->setXp($XPCharacter);
        $character->setHealthPoints($HPCharacter);
        $whoIsDead = $character . 'IsDead';
        return $$whoIsDead = true;
    }
}