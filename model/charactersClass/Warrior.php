<?php
namespace App\model\charactersClass;
use App\model\Character;

class Warrior extends Character{
    public function __construct($data){
        parent::__construct($data, "warrior");
    }

    public function avoidDamage(){
        $result = rand(1, 4);
        if($result == 4){
            return true;
        }else {
            return false;
        }
    }

    public function calculDamage(Character $attackingCharacter) : int {
        $damage = parent::calculDamage($attackingCharacter);
        $asset = $this->asset();
        if($this->avoidDamage()){
            $damage -= $asset;
            $bonus = "Attaque parée ! Moins {$asset} de dégats subis.";
            $this->setBonus($bonus);
        }
        return $damage;
    }

    public function criticalHit() : bool {
        $result = rand(1,5);
        if($result == 5){
            return true;
        }
        return false;
    }

    public function giveDamage(Character $targetCharacter){
        if($this->criticalHit()){
            $targetCharacter->setCriticalHit();
        }
        return parent::giveDamage($targetCharacter);
    }

}