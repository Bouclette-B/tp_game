<?php
namespace App\model\charactersClass;
use App\model\Character;

class Wizard extends Character{
    public function __construct($data){
        parent::__construct($data, 'wizard');
    }
    
    public function receiveDamage($strength, $targetCharacter)
    {
        $damage = rand(0, 10) + (2 * $strength);
        return parent::receiveDamage($damage, $targetCharacter);
    }

    public function freeze(){
        $result = rand(1,4);
        if($result == 4){
            return true;
        }
        return false;
    }

    public function hit(Character $targetCharacter, Character $attackingCharacter, $strength){
        $freeze = $attackingCharacter->freeze();
        if($freeze){
            $targetCharacter->setFreeze(2);
        }
        [$HP, $damage] = parent::hit($targetCharacter, $attackingCharacter, $strength);
        return [$HP, $damage];
    }

}