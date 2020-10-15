<?php
class BackController {
    public function isPost($data=NULL) {
        if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST[$data])){
            return $_POST[$data];
        } elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
            return true;
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