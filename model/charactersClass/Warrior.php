<?php
namespace App\model\charactersClass;
use App\model\Character;
use App\model\CharactersManager;

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

    public function receiveDamage($strength, $targetCharacter){
        $avoidDamageSuccess = $this->avoidDamage();
        $asset = $this->asset();
        if($avoidDamageSuccess){
            $damage = (rand(0, 10) + (2*$strength));
            $damage -= ($asset*2);
            $bonus = "Attaque parée ! Moins - 2 de dégats subis.";
            $targetCharacter->setBonus($bonus);
        }else{
            $damage = rand(0, 10) + (2 * $strength);
        }
        [$HP, $damage] = parent::receiveDamage($damage, $targetCharacter);
        return [$HP, $damage] ;
    }

    public function criticalHit(){
        $result = rand(1,5);
        if($result == 5){
            return true;
        }
        return false;
    }

    public function hit(Character $targetCharacter, $strength){
        $criticalHit = $this->criticalHit();
        if($criticalHit){
            $targetCharacter->setCriticalHit();
        }
        [$HP, $damage] = parent::hit($targetCharacter, $strength);
        return [$HP, $damage];
    }

}