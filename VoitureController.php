<?php

namespace Controllers;

// Notre ArticleController va nous permettre de gérer tout ce qui touche aux articles
// * Affichage des articles
// * Affichage d'un article précis
// * Création d'un article
// * Modification d'un article
// * Suppression d'un article
// ...

class VoitureController {

    public function displayAllVoiture() {

        $model = new \Models\Voitures();
        $voitures = $model->getAllVoitures();

        require_once('config/config.php');
        $template = "home.phtml";
        include_once 'views/layout.phtml';
    }

     // Méthode permettant d'afficher le formulaire VIDE d'ajout d'une voiture
     public function displayFormForAddVoiture() {
      
        $model = new \Models\Categories();
        $categories = $model->getAllCategories();
        
        $model = new \Models\Carburants();
        $carburants = $model->getAllCarburants();
        
        $model = new \Models\Transmissions();
        $transmissions = $model->getAllTransmissions();
        
        $model = new \Models\Marques();
        $marques = $model->getAllMarques();
        
        $model = new \Models\Modeles();
        $modeles = $model->getAllModeles();
        

        require_once('config/config.php');
        $template = "formAddVoiture.phtml";
        include_once 'views/layout.phtml';
     }

     // Méthode permettant d'afficher les détails d'un article précis
     public function displayVoitureById($id) {

         $model = new \Models\Voitures();
         $voiture = $model->getVoitureById($id);
         $allImages = $model->getAllImagesById($id);

         $template = "displayAllDetailsOfVoiture.phtml";
         include_once 'views/layout.phtml';
     }


     // Méthode permettant d'ajouter une voiture ( avec vérification du remplissage du formulaire )
     public function verifAddOneVoiture() {

         
         $errors = [];
         $valids = [];

         $addVoiture = [
                         'addName' => '',
                         'addAnnee' => '',
                         'addPrix' => '',
                        'addCarburant' => '',
                         'addTransmission' => '',
                        'addKilometrage' => '',
                        'addImgprincipale' => '',
                        'addDescription' => '',
                        'addCategorie' => '',
                        'addMarque' => '',
                        'addModele'=> ''
         ];

         if(array_key_exists('name', $_POST) && array_key_exists('annee', $_POST)
                 && array_key_exists('prix', $_POST) && array_key_exists('carburant', $_POST)
                 && array_key_exists('transmission', $_POST) && array_key_exists('kilometrage', $_POST)
                 && array_key_exists('description', $_POST) 
                 && array_key_exists('categorie', $_POST) && array_key_exists('marque', $_POST)
                 && array_key_exists('modele', $_POST)) {
// var_dump($_POST);
//  exit();
//              // Histoire de ne courir aucun risque d'injection de code ou de données malveillantes,
             // passons toutes les informations du formulaire à la "machine à laver"
             // Notre méthode de nettoyage est disponible dans notre model "Results", elle s'appelle "cleaned()"
             $model = new \Models\Results();
             $addVoiture = [
                 
                         'addName'  => $model->cleaned($_POST['name']),
                         'addAnnee' => $model->cleaned($_POST['annee']),
                         'addPrix' => $model->cleaned($_POST['prix']),
                        'addCarburant' => $model->cleaned($_POST['carburant']),
                         'addTransmission' => $model->cleaned($_POST['transmission']),
                        'addKilometrage' => $model->cleaned($_POST['kilometrage']),
                        'addImgprincipale' =>"",
                        'addDescription' => $model->cleaned($_POST['description']),
                        'addCategorie' => $model->cleaned($_POST['categorie']),
                        'addMarque' => $model->cleaned($_POST['marque']),
                        'addModele' => $model->cleaned($_POST['modele']),
                        ];


             // Notre tableau associatif contient désormais des données sûres, nettoyées !!!

            // Vérifions maintenant le remplissage du formulaire.
             // A chaque erreur détectée, on ajoute une mention dans notre tableau d'erreurs, initialement vide.

             
            if($addVoiture['addName'] == '')
                 $errors[] = "Veuillez remplir le champ 'nom' !";

             if($addVoiture['addAnnee'] == '')
                 $errors[] = "Veuillez remplir le champ 'annee' !";

             if (!is_numeric($addVoiture['addPrix']) || $addVoiture['addPrix'] == '' || $addVoiture['addPrix'] <= 0)
                 $errors[] = "Veuillez remplir le champ 'Prix' correctement !";


             if($addVoiture['addCarburant'] == '')
                 $errors[] = "Veuillez remplir le champ 'Carburant' !";
                 
              if($addVoiture['addTransmission'] == '')
                 $errors[] = "Veuillez remplir le champ 'transmission' !";
                 
               if($addVoiture['addKilometrage'] == '')
                 $errors[] = "Veuillez remplir le champ 'kilometrage' !";
                
                 
                 if($addVoiture['addDescription'] == '')
                 $errors[] = "Veuillez remplir le champ 'description' !";
                 
                 if($addVoiture['addCategorie'] == '')
                 $errors[] = "Veuillez remplir le champ 'Categories' !";
                 
                 if($addVoiture['addMarque'] == '')
                 $errors[] = "Veuillez remplir le champ 'marque' !";
                 
                 if($addVoiture['addModele'] == '')
                 $errors[] = "Veuillez remplir le champ 'modele' !";

             
             // Si vous avez besoin de vérifier un champ de type "email" :
             // if(!filter_var($user['email'], FILTER_VALIDATE_EMAIL))
             //    $errors[] =  'Veuillez renseigner un email valide SVP !';

             if(count($errors) == 0) {

                 // Notre formulaire contient la possibilité de charger une image, on va donc utiliser notre
                 // méthode "upload" présente dans notre model "Uploads".
                 // Si aucune image n'a été uploadée dans le formulaire, on va garder dans notre tableau 'noPicture.png'
                 // A défaut, on change le nom de l'image dans le tableau $addVoiture['addImg']
                 if(isset($_FILES['img_voitures']) && $_FILES['img_voitures']['name'] != '') {
                     $dossier = "img_voitures";
                     $model = new \Models\Uploads();
                     $addVoiture['addImgprincipale'] = $model->upload($_FILES['img_voitures'], $dossier, $errors);
                 }

                 $model = new \Models\Results();
                 $dateActuelle = $model->dateNow('Y-m-d H:i:s', 'Europe/Paris');

                 $data = [
                             $addVoiture['addName'],
                             $addVoiture['addAnnee'],
                             $addVoiture['addPrix'],
                             $addVoiture['addCarburant'],
                             $addVoiture['addTransmission'],
                             $addVoiture['addKilometrage'],
                             $model->cleaned($addVoiture['addImgprincipale']), // On oublie pas de nettoyer le nom de l'image !
                             $addVoiture['addDescription'],
                             $addVoiture['addCategorie'],
                             $addVoiture['addMarque'],
                             $addVoiture['addModele']
                             
                 ];

                $add = new \Models\Voitures();
                 $addMore = $add->addOneVoiture($data);
                 $valids[] = "La voiture a bien été enregistrée !";
             }

             // Dans l'optique où le formulaire ne serait pas correctement rempli, on affiche les erreurs
             // Et on réalimente notre "select" des catégories
             // $add = new \Models\Categories();
             // $categories = $add->getAllCategories();
         }
         require_once('config/config.php');
         $template = "formAddVoiture.phtml";
        include_once 'views/layout.phtml';
     }
     
     // Méthode permettant d'afficher le formaulaire de modification d'une voiture

public function displayFormForUpdateVoiture($id) {
        
      
        $model = new \Models\Categories();
        $categories = $model->getAllCategories();
        
        $model = new \Models\Carburants();
        $carburants = $model->getAllCarburants();
        
        $model = new \Models\Transmissions();
        $transmissions = $model->getAllTransmissions();
        
        $model = new \Models\Marques();
        $marques = $model->getAllMarques();
        
        $model = new \Models\Modeles();
        $modeles = $model->getAllModeles();
        
        $model = new \Models\Voitures();
        $voiture = $model->getVoitureById($id);
        
        require_once('config/config.php');
        $template = "formUpdateVoiture.phtml";
        include_once 'views/layout.phtml';
     }
     
     public function verifUpdateOneVoiture($id) {

         
         $errors = [];
         $valids = [];

         $data = [
                        'name'          =>'', 
                        'annee'         =>'', 
                        'prix'          =>'', 
                        'carb_id'       =>'', 
                        'trans_id'      =>'', 
                        'kilometrage'   =>'', 
                        'image_pr'      =>'', 
                        'description'   =>'', 
                        'cat_id'        =>'', 
                        'marq_id'       =>'', 
                        'mod_id'        =>''
                    ];
         
         if(array_key_exists('name', $_POST) && array_key_exists('annee', $_POST)
                 && array_key_exists('prix', $_POST) && array_key_exists('carburant', $_POST)
                 && array_key_exists('transmission', $_POST) && array_key_exists('kilometrage', $_POST)
                 && array_key_exists('description', $_POST) 
                 && array_key_exists('categorie', $_POST) && array_key_exists('marque', $_POST)
                 && array_key_exists('modele', $_POST)) {
                     
                     
            $data = [
                        'name'          =>$_POST['name'], 
                        'annee'         =>$_POST['annee'], 
                        'prix'          =>$_POST['prix'], 
                        'carb_id'       =>$_POST['carburant'], 
                        'trans_id'      =>$_POST['transmission'], 
                        'kilometrage'   =>$_POST['kilometrage'], 
                        'image_pr'      =>"", 
                        'description'   =>$_POST['description'], 
                        'cat_id'        =>$_POST['categorie'], 
                        'marq_id'       =>$_POST['marque'], 
                        'mod_id'        =>$_POST['modele']
                    ];
            
            if($data['name'] == "")  
                $errors[] = "Veuillez remplir le champ 'Nom' !";
                
            if($data['annee'] == "")  
                $errors[] = "Veuillez remplir le champ 'Annee' !";    
                
            if($data['prix'] == "")  
                $errors[] = "Veuillez remplir le champ 'Prix' !";  
                
            if($data['carb_id'] == "")  
                $errors[] = "Veuillez remplir le champ 'Carburant' !";   
                
            if($data['trans_id'] == "")  
                $errors[] = "Veuillez remplir le champ 'Transmissions' !";  
                
            if($data['kilometrage'] == "")  
                $errors[] = "Veuillez remplir le champ 'Kilometrage' !";    
                
            if($data['description'] == "")  
                $errors[] = "Veuillez remplir le champ 'Description' !";    
                
            if($data['cat_id'] == "")  
                $errors[] = "Veuillez remplir le champ 'Categories' !";    
                
            if($data['marq_id'] == "")  
                $errors[] = "Veuillez remplir le champ 'Marque' !";    
                
            if($data['mod_id'] == "")  
                $errors[] = "Veuillez remplir le champ 'Modele' !";  
            // Vérifier si tous les champs sont remplis correctement    
            // Si pas d'erreur --> Uploader l'image si une nouvelle image a été mise dans le formulaire et supprimer la précédente
                // update des données
            // Si erreur --> message d'erreur
                    
 
            if(count($errors) == 0) {
                if(isset($_FILES['img_voitures']) && $_FILES['img_voitures']['name'] != '') {
                    $dossier = "img_Voitures";
                    $model = new \Models\Uploads();
                    $updateVoiture['updateImgprincipale'] = $model->upload($_FILES['img_voitures'], $dossier, $errors);
                }
            

            // Notre formulaire contient la possibilité de charger une image, on va donc utiliser notre
            // méthode "upload" présente dans notre model "Uploads".
            // Si aucune image n'a été uploadée dans le formulaire, on va garder dans notre tableau 'noPicture.png'
            // A défaut, on change le nom de l'image dans le tableau $addVoiture['addImg']
            
                
                $update = new \Models\Voitures();
                $updateMore = $update->updateOneVoiture($data, $id);
                
                $valids[] = "La voiture a bien été modifiée !";
            }
        }   

        require_once('config/config.php');
        $template = "formUpdateVoiture.phtml";
        include_once 'views/layout.phtml';
    }
    
    public function verifDeleteOneVoiture($id){
     
    $delete = new \Models\Voitures();
                $deleteMore = $delete->deleteOneVoiture($id);
                
                $valids[] = "La voiture a bien été supprimée !";
            }
            
    public function searchVoiture(){
        $content = file_get_contents("php://input");
        $data = json_decode($content, true);
        $search = "%".$data['textToFind']."%";
        
        $model= new \Models\Voitures();
        $voitures = $model->searchVoitures($search);
        $numberOfVoitures = count($voitures);
        
     
        include_once 'views/voitures.phtml';
    }
   }    
