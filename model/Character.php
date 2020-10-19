<?php
namespace App\model;
class Character {
    private $_id;
    private $_name;
    private $_healthPoints = 100;
    private $_level = 1;
    private $_xp = 0;
    private $_strength = 1;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data){
        foreach($data as $key => $value){
            $method = 'set' . ucfirst($key);
            if(method_exists($this, $method)){
                $this->$method($value);
            }
        }
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

    public function hit(Character $targetCharacter, $strength) {
        [$HP, $damage] = $targetCharacter->receiveDamage($strength);
        return [$HP, $damage];
    }

    public function receiveDamage($strength) {
        $damage = rand(0, 10) + (2 * $strength);
        $this->_healthPoints -= $damage;
        $HP = $this->_healthPoints;
        return [$HP, $damage];
    }

    public function levelUp(Character $character){
            $level = $character->level() + 1;
            $strength = $character->strength() + 1;
            $xp = 0;
            $character->setLevel($level);
            $character->setStrength($strength);
            $character->setXp($xp);
            $character->setHealthPoints(100);
            return $levelUpName = $character->name();
    }

}