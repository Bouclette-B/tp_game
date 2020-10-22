<?php
namespace App\model;
abstract class Character {
    private $_id;
    private $_name;
    private $_healthPoints = 100;
    private $_level = 1;
    private $_xp = 0;
    private $_strength = 1;
    private $_type;
    private $_asset = 1;
    private $_bonus = "";
    private $_malus = [
        'freeze' => [
            'sentence' => "",
            'remainingRounds' => 0
        ],
        'criticalHit' => ""
        
    ];

    public function __construct(array $data, $type)
    {
        $this->hydrate($data);
        $this->setType($type);
    }

    public function hydrate(array $data){
        foreach($data as $key => $value){
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
    }
    
    public function malus(){
        return $this->_malus;
    }

    public function bonus(){
        return $this->_bonus;
    }

    public function type(){
        return $this->_type;
    }

    public function asset(){
        return $this->_asset;
    }

    public function level(){
        return $this->_level;
    }

    public function xp(){
        return $this->_xp;
    }

    public function strength(){
        return $this->_strength;
    }

    public function id(){
        return $this->_id;
    }

    public function name(){
        return $this->_name;
    }

    public function healthPoints(){
       return $this->_healthPoints;
    }

    public function getCriticalHit(){
        return $this->_malus['criticalHit'];
    }

    public function getFreeze(){
        return $this->_malus['freeze']['sentence'];
    }

    public function setFreeze($rounds){
        $this->_malus['freeze']['sentence'] = "Freeze ! Impossible d'attaquer au prochain tour !";
        $this->_malus['freeze']['remainingRounds'] = $rounds;
        }

    public function setCriticalHit(){
        $this->_malus['criticalHit'] = "Coup critique ! Dégâts doublés !";
    }

    public function setBonus($bonus){
        if(is_string($bonus)){
            $this->_bonus = $bonus;
        }
    }

    public function setType($type){
        $this->_type = $type;
    }

    public function setAsset($asset){
        $asset = (int)$asset;
        if($asset > 0){
            $this->_asset = $asset;
        }
    }

    public function setLevel($level){
        $level = (int)$level;
        if($level > 0){
            $this->_level = $level;
        }
    }

    public function setStrength($strength){
        $strength = (int)$strength;
        $this->_strength = $strength;
    }

    public function setXp($xp){
        $xp = (int)$xp;
        $this->_xp = $xp;
    }

    public function setId($id){
        $id = (int)$id;
        if($id > 0){
            $this->_id = $id;
        }
    }

    public function setName($name){
        if(is_string($name)){
            $this->_name = $name;
        }
    }

    public function setHealthPoints($healthPoints){
        $healthPoints = (int)$healthPoints;
        if($healthPoints >= 100){
            $this->_healthPoints = 100;
        }elseif($healthPoints <= 100 && $healthPoints > 0){
            $this->_healthPoints = $healthPoints;
        }
    }

    public function stopFreeze(){
            $this->_malus['freeze']['sentence'] = "";
            $this->_malus['freeze']['remainingRounds'] = 0;
    }

    public function hit(Character $targetCharacter, Character $attackingCharacter){
        if($this->characterCanHit()){
            return $this->giveDamage($targetCharacter);
        }else{
            $damage = 0;
            $HP = $targetCharacter->_healthPoints;
            return [$HP, $damage];
        }
    }

    public function characterCanHit() : bool{
        $rounds = $this->_malus['freeze']['remainingRounds'];
        if($rounds == 2){
            $rounds -= 1;
            $this->setFreeze($rounds);
            return false;
        }elseif($rounds == 1){
            $rounds -= 1;
            $this->setFreeze($rounds);
            $this->_malus['freeze']['sentence'] = "Frozen ! Tu ne peux pas attaquer ce tour-ci.";
            return false;
        }elseif($rounds == 0){
            $this->stopFreeze();
            return true;
        }
    }

    public function calculDamage(Character $attackingCharacter) : int {
        return rand(1, 10) + (2 * $attackingCharacter->strength());
    }

    public function giveDamage(Character $targetCharacter) {
        $damage = $this->calculDamage($targetCharacter);
        $malus = $targetCharacter->malus();
        if($malus['criticalHit'] != ""){
            $damgage  = $damage * 2;
        }
        $targetCharacter->_healthPoints -= $damage;
        $HP = $targetCharacter->_healthPoints;
        return [$HP, $damage];
    }

    public function levelUp(Character $character){
            $level = $character->level() + 1;
            $strength = $character->strength() + 1;
            $asset = $character->asset() + 1;
            $xp = 0;
            $character->setLevel($level);
            $character->setStrength($strength);
            $character->setXp($xp);
            $character->setHealthPoints(100);
            $character->setAsset($asset);
            return $levelUpName = $character->name();
    }

    public function getCharacterClass(Character $character){
        $className = $character->type();
        if($className == "warrior"){
            $characterClass = "Guerrier";
        }elseif($className == "wizard"){
            $characterClass = "Sorcier";
        }
        return $characterClass;
    }

    public function resetBonus(){
        $this->_bonus = "";
    }

    public function resetMalus(){
        $this->_malus['criticalHit'] = "";
    }

    public function flee(){
        $result = rand(1, 2);
        if($result == 1){
            return true;
        }
        return false;
    }

}   