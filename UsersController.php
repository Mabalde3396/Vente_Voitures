<?php

namespace Controllers;

// Notre UsersController va nous permettre de gérer tout ce qui touche à l'utilisateur
// * Affichage des utilisateurs
// * Affichage d'un utilisateur précis
// * Création d'un compte
// * Modification d'un compte
// * Suspension / Suppression d'un compte
// * Affichage du formulaire de connexion de l'utilisateur
// * Soumission du formulaire de connexion de l'utilisateur
// * Déconnexion de l'utilisateur
// ...

class UsersController {

    // Méthode permettant d'afficher la liste de tous les utilisateurs
    public function displayAllUsers() {
        $model = new \Models\Users();
        $users = $model->getAllUsers();

        $template = "users.phtml";
        include_once 'views/layout.phtml';
    }

    // Méthode permettant d'afficher un utlisateur via son id ( l'id devra être passé en argument )
    public function displaylUserById($id) {
        $model = new \Models\Users();
        $users = $model->getUserById($id);
        //...
    }

    // Méthode permettant d'afficher le formulaire de connexion
    public function displayFormConnect() {
        require('config/config.php');
        $template = "connect.phtml";
        include_once 'views/layout.phtml';
    }
    
    
    // Méthode permettant de soumettre le formulaire de connexion à la vérification
    public function submitFormConnect() {
        
        $errors = [];
         $valids = [];

         $connect = [
                         'connectEmail' => '',
                        'connectPassword' => ''
                    
         ];

         if(array_key_exists('email', $_POST) && array_key_exists('password', $_POST)){
             
  $model = new \Models\Results();
             $connect = [
                 
                         'connectEmail'  => $model->cleaned($_POST['email']),
                         'connectPassword' => $model->cleaned($_POST['password'])
                         
                        
                        ];
                        
                        if($connect['connectEmail'] == '')
                 $errors[] = "Veuillez remplir le champ 'mail' !";

             if($connect['connectPassword'] == '')
                 $errors[] = "Veuillez remplir le champ 'mot de passe' !";
                 
            if(count($errors) == 0) {

                 // Notre formulaire contient la possibilité de charger une image, on va donc utiliser notre
                 // méthode "upload" présente dans notre model "Uploads".
                 // Si aucune image n'a été uploadée dans le formulaire, on va garder dans notre tableau 'noPicture.png'
                 // A défaut, on change le nom de l'image dans le tableau $addVoiture['addImg']
                 
                 $data = [
                             $connect['connectEmail'],
                             $connect['connectPassword']
                            
                 ];

                $model = new \Models\Users();
                 $find = $model->verifyIfExist($connect['connectEmail']);
                 if($find != false) {
                     

                       if (password_verify($connect['connectPassword'], $find['password'])) {
                           $_SESSION['connected'] = true;
                           $_SESSION['user'] = [
                               'id' =>$find['id'], 
                               'username'=>$find['username'],
                               'email'=>$find['email'],
                               'image'=>$find['user_img'], 
                               'role'=>$find['role']];
                               
                               header('Location: index.php?road=home');
                               exit();
                           
                         }else{
                             $errors[]= "Erreur d'identifications";
                         }
                 }
                 else {
                     $errors[] = "Aucun compte avec cette adresse mail";
                 }
                 

             // Dans l'optique où le formulaire ne serait pas correctement rempli, on affiche les erreurs
             // Et on réalimente notre "select" des catégories
             // $add = new \Models\Categories();
             // $categories = $add->getAllCategories();
         }
         require_once('config/config.php');
         $template = "connect.phtml";
        include_once 'views/layout.phtml';
     }

    }   
    // Méthode permettant d'afficher le formulaire d'inscription

    public function displayFormAddUser() {
        require('config/config.php');
        $template = "addUser.phtml";
        include_once 'views/layout.phtml';
    }
    // Méthode permettant de soumettre le formulaire de connexion à la vérification
    public function verifAddOneUser() {
        
        $errors = [];
         $valids = [];

         $addUser = [
                         'addUsername' => '',
                         'addUserimg' => '',
                         'addUsermail' => '',
                        'addPassword' => ''
                    
         ];

         if(array_key_exists('username', $_POST)
                 && array_key_exists('email', $_POST) && array_key_exists('password', $_POST)){
 
 
             // Histoire de ne courir aucun risque d'injection de code ou de données malveillantes,
             // passons toutes les informations du formulaire à la "machine à laver"
             // Notre méthode de nettoyage est disponible dans notre model "Results", elle s'appelle "cleaned()"
             $model = new \Models\Results();
             $addUser = [
                 
                         'addUsername'  => $model->cleaned($_POST['username']),
                         'addUserimg' => "",
                         'addUsermail' => $model->cleaned($_POST['email']),
                         'addPassword' => $model->cleaned($_POST['password']),
                         
                        
                        ];

             // Notre tableau associatif contient désormais des données sûres, nettoyées !!!

            // Vérifions maintenant le remplissage du formulaire.
             // A chaque erreur détectée, on ajoute une mention dans notre tableau d'erreurs, initialement vide.

             
            if($addUser['addUsername'] == '')
                 $errors[] = "Veuillez remplir le champ 'nom utilisateur' !";

            //  if($addUser['addUserimg'] == '')
                //  $errors[] = "Veuillez remplir le champ 'photo' !";
                 
             if($addUser['addUsermail'] == '')
                 $errors[] = "Veuillez remplir le champ 'email' !";
                 
              if($addUser['addPassword'] == '')
                 $errors[] = "Veuillez remplir le champ 'mot de passe' !";
                 
               
             
             // Si vous avez besoin de vérifier un champ de type "email" :
             // if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL))
             //    $errors[] =  'Veuillez renseigner un email valide SVP !';

             if(count($errors) == 0) {

                 // Notre formulaire contient la possibilité de charger une image, on va donc utiliser notre
                 // méthode "upload" présente dans notre model "Uploads".
                 // Si aucune image n'a été uploadée dans le formulaire, on va garder dans notre tableau 'noPicture.png'
                 // A défaut, on change le nom de l'image dans le tableau $addVoiture['addImg']
                 if(isset($_FILES['users']) && $_FILES['users']['name'] != '') {
                     $dossier = "users";
                     $model = new \Models\Uploads();
                     $addUser['addUserimg'] = $model->upload($_FILES['users'], $dossier, $errors);
                 }

                 $data = [
                             $addUser['addUsername'],
                             $addUser['addUserimg'],
                             $addUser['addUsermail'],
                            password_hash($addUser['addPassword'], PASSWORD_DEFAULT)
                 ];

                $add = new \Models\Users();
                 $addMore = $add->addOneUser($data);
                 $valids[] = "L'utilisateur a bien été crée !";
             }

             // Dans l'optique où le formulaire ne serait pas correctement rempli, on affiche les erreurs
             // Et on réalimente notre "select" des catégories
             // $add = new \Models\Categories();
             // $categories = $add->getAllCategories();
         }
         require_once('config/config.php');
         $template = "addUser.phtml";
        include_once 'views/layout.phtml';
     }
        // Vérification du remplissage du formulaire ( aucun champ vide )
        // Vérifier la correspondance avec la BDD ( email et MDP avec password_hash )

        // Si les identifiants sont bons, création du $_SESSION et header("Location: index.php"); exit();
        // Si le formulaire n'est pas bien rempli ( champ vide ) et pas les bons identifiants :
            // Affichez le ou les messages d'erreurs.
        // var_dump("Vérification du formulaire à réaliser !"); 
        // exit();
public function deconnexion() {
        session_destroy();
        
        header('Location: index.php?road=home');
        exit();
    }
    //...
}