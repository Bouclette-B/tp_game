<?php
namespace App\controller;
class BackController {
    public function isPost($data) {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$data])){
            return $_POST[$data];
        }
        return false;
    }

    public function render($viewName, $viewData) {
        ob_start();
        extract($viewData);
        require('./view/' . $viewName . '.php');
        $content = ob_get_clean(); 
        require('./template/template.php');
    }
}