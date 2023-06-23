<?php

session_start();


spl_autoload_register(function($class) {
    require_once lcfirst(str_replace('\\','/', $class)) . '.php';
});

// Ainsi, nous n'aurons plus à nous préocuper des fichiers à requérir, notre autoload le fait pour nous !

if(array_key_exists('road', $_GET)) :

    switch($_GET['road']) {

        // ------- AFFICHAGE DE LA PAGE D'ACCUEIL DE NOTRE SITE AVEC TOUS LES ARTICLES ------- //
        case 'home':
            // On va instancier notre HomeController et pas conséquent, notre autoloader s'exécute.
            $controller = new Controllers\VoitureController();
            // Appel de notre méthode "displayAllArticle()" pour afficher la page d'accueil avec tous les articles.
            $controller->displayAllVoiture();
        break;


        // ------- AFFICHAGE DES DETAILS DE L'ARTICLE SELECTIONNE VIA SON ID ------- //
        case 'detailsOfOneVoiture':
            if(array_key_exists('id', $_GET)) {
                $controller = new Controllers\VoitureController();
                $controller->displayVoitureById($_GET['id']);
            } else {
                header('location: index.php');
                exit;
            }
        break;


        // ------- AFFICHAGE DU FORMULAIRE D'AJOUT D'UNE VOITURE ------- //
        case 'displayFormAddVoiture':
            $controller = new Controllers\VoitureController();
            $controller->displayFormForAddVoiture();
        break;
        
        //------ AFFICHAGE DU FORMULAIRE DE MODIFICATION D'UNE VOITURE -----------//
        case 'displayFormUpdateVoiture':
            $controller = new Controllers\VoitureController();
            $controller->displayFormForUpdateVoiture($_GET['id']);
        break;
        
       //-------AFFICHAGE DES MARQUES-------------------// 
        case 'displayAllMarque':
            $controller = new Controllers\MarqueController();
            $controller->displayAllMarque();
        break;


        // ------- SOUMISSION DU FORMULAIRE D'AJOUT D'UNE VOITURE ------- //
        // ------- VERIFICATION + AJOUT DANS LE BDD ou AFFICHAGE DES ERREURS ) ------- //
        case 'submitFormAddVoiture':
            $controller = new Controllers\VoitureController();
            $controller->verifAddOneVoiture();
        break;


        // ------- PAGE DES UTILISATEURS: AFFICHE TOUS LES UTILISATEURS ------- //
        case 'users':
            $controller = new Controllers\UsersController();
            $controller->displayAllUsers();
        break;


// ------- AFFICHAGE DU FORMULAIRE DE D'INSCRIPTION ------- //
        case 'addUser':
            $controller = new Controllers\UsersController();
            $controller->displayFormAddUser();
        break;
        
         // ------- VERIFICATION + AJOUT DANS LE BDD ou AFFICHAGE DES ERREURS ) ------- //
        case 'submitFormAddUser':
            $controller = new Controllers\UsersController();
            $controller->verifAddOneUser();
        break;


 // ------- AFFICHAGE DU FORMULAIRE DE CONNEXION ------- //
        case 'connect':
            $controller = new Controllers\UsersController();
            $controller->displayFormConnect();
        break;

//-------------DECONNEXION------------------------------------//
        case 'disconnect':
            $controller = new Controllers\UsersController();
            $controller->deconnexion();
        break;
        // ------- SOUMISSION DU FORMULAIRE DE CONNEXION ------- //
        case 'submitConnect':
            $controller = new Controllers\UsersController();
            $controller->submitFormConnect();
        break;

 //-------------VERIFICATION DE LA MODIFICATION------------//
        
        case 'submitFormUpdateVoiture':
            $controller = new Controllers\VoitureController();
            $controller->verifUpdateOneVoiture($_GET['id']);
        break;
        
//----------SUPPRESSION DE LA VOITURE---------------------------//
case 'deleteVoiture':
    $controller = new Controllers\VoitureController();
    $controller->verifDeleteOneVoiture($_GET['id']);
    break;
    
//--------------RECHERCHE DE VOITURE-----------------------------//
case 'searchVoiture':
    $controller = new Controllers\VoitureController();
    $controller->searchVoiture();
break;
 // --------- ------SI LA ROUTE DANS L'URL N'EST PAS PRESENTE DANS NOTRE SWITCH, REDIRECTION VERS L'ACCUEIL ------- //
        default:
            header('location: index.php?road=home');
            exit;
    }
// ------- SI Y'A PAS DE ROUTE DANS L'URL, ON REDIRIGE VERS L'ACCUEIL DU SITE ------- //
else :
    header('Location: index.php?road=home');
    exit;

endif;