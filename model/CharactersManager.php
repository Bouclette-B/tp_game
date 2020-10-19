<?php
namespace App\model;
use \PDO;
class CharactersManager {
    private $_db;

    public function __construct($db)
    {
        $this->_db = $db;
    }

    public function addCharacter(Character $newCharacter)
    {
        $characterInfo = $this->_db->prepare('INSERT INTO characters (name, type) VALUES(:name, :type)');
        $characterInfo->bindValue(':name', $newCharacter->name());
        $characterInfo->bindValue(':type', $newCharacter->type());
        $characterInfo->execute();
    }

    public function updateCharacter(Character $character)
    {
        $request = $this->_db->prepare('UPDATE characters SET healthPoints = :newHealthPoints, level = :level, xp = :xp,  strength = :strength WHERE id =' .$character->id());
        $request->bindValue(':newHealthPoints', $character->healthPoints(), PDO::PARAM_INT);
        $request->bindValue(':level', $character->level(), PDO::PARAM_INT);
        $request->bindValue(':xp', $character->xp(), PDO::PARAM_INT);
        $request->bindValue(':strength', $character->strength(), PDO::PARAM_INT);
        $request->execute();
    }

    public function deleteCharacter(Character $character)
    {
        $this->_db->query('DELETE FROM characters WHERE id = ' .$character->id());
        echo "Personnage décédé.";
    }

    public function getCharacter($info)
    {
        if(is_int($info)){
            $request = $this->_db->query('SELECT * FROM characters WHERE id =' .$info);
            $data = $request->fetch(PDO::FETCH_ASSOC);
        return new Character($data);
        } else {
            $request = $this->_db->prepare('SELECT * FROM characters WHERE name = :name');
            $request->execute([':name' => $info]);
            $data = $request->fetch(PDO::FETCH_ASSOC);
        return new Character($data);
        }
    }

    public function checkCharacterExistence($info)
    {
        if(is_int($info)){
            $request = $this->_db->query('SELECT * FROM characters WHERE id =' .$info);
            $character = $request->fetchColumn();
            return $character;    
        }
        $request = $this->_db->prepare('SELECT * FROM characters WHERE name = :name');
        $request->execute([':name' => $info]);
        $character = $request->fetchColumn();
        return $character;    
    }

    public function countCharacters()
    {
        $request = $this->_db->query('SELECT COUNT(*) as charactersCount from characters');
        $count = $request->fetchColumn();
        return $count;
    }

    public function getList($name=NULL)
    {
        $characters = [];
        if($name){
            $request = $this->_db->prepare('SELECT * FROM characters WHERE name <> :name ORDER BY name');
            $request->execute([':name' => $name]);
            $charactersList = $request->fetchAll(PDO::FETCH_ASSOC);
            foreach($charactersList as $characterInfo){
                $characters[] = new Character($characterInfo);
            }
            return $characters;
        }
        $request = $this->_db->query('SELECT * FROM characters');
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdList($id){
        $request = $this->_db->prepare('SELECT id FROM characters WHERE id <> :id ORDER BY id');
        $request->execute([':id' => $id]);
        return $request->fetchAll(PDO::FETCH_ASSOC);
    }

    public function storeCharacterInSession($sessionName, Character $character){
        $_SESSION[$sessionName] = serialize($character);
    }
}