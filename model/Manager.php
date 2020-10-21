<?php
namespace App\model;
use \PDO;
class Manager
{
    public function dbConnect() {
        $db = new PDO('mysql:host=localhost;dbname=tp_game;charset=utf8', 'root', 'root');
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }
}