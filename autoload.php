<?php
function loadClass($className){
    $className = str_replace("\\", "/", $className);
    $className = str_replace("App", "", $className);
    $path = "." . $className . ".php";
    require_once($path);
}

spl_autoload_register('loadClass');