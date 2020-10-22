<?php
namespace App\model\charactersClass;
use App\model\Character;

class Wizard extends Character{
    public function __construct($data){
        parent::__construct($data, 'wizard');
    }
    
    public function freeze(){
        $result = rand(1,4);
        if($result == 4){
            return true;
        }
        return false;
    }

    public function giveDamage(Character $targetCharacter){
        if($this->freeze()){
            $targetCharacter->setFreeze(2);
        }
        return parent::giveDamage($targetCharacter);
    }
}