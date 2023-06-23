<?php

namespace Controllers;

class HomeController {

    public function display() {

        $model = new \Models\Voitures();
        $articles = $model->getAllVoitures();

        require_once('config/config.php');
        $template = "home.phtml";
        include_once 'views/layout.phtml';
    }
}