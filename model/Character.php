<?php
class Character {
    private $_id;
    private $_name;
    private $_healthPoints;

    const ITS_ME = 1;
    const CHARACTER_KILLED = 2;
    const CHARACTER_HIT = 3;

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

    public function id(){
        return $this->_id;
    }

    public function name(){
        return $this->_name;
    }

    public function healthPoints(){
       return $this->_healthPoints;
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

    public function hit(Character $targetCharacter) {
        if($targetCharacter->id() == $this->id()){
            return self::ITS_ME;
        }
        [$HP, $damage] = $targetCharacter->receiveDamage();
        return [$HP, $damage];
    }

    public function receiveDamage() {
        $damage = rand(0, 10);
        $this->_healthPoints -= $damage;
        $HP = $this->_healthPoints;
        return [$HP, $damage];
    }

}