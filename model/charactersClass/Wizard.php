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
        //$result = rand(1,5);
        $result = 5;
        if($result == 5){
            return true;
        }
        return false;
    }

    public function hit(Character $targetCharacter, $strength){
        $freeze = $this->freeze();
        if($freeze){
            $targetCharacter->setFreeze();
        }
        [$HP, $damage] = parent::hit($targetCharacter, $strength);
        return [$HP, $damage];
    }

}