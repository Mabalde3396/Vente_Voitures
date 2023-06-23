<?php

namespace Models;

// Notre model Articles va nous permettre de stocker toutes nos méthodes permettant de réaliser des requêtes
// SQL liées aux articles
// * Rechercher tous les articles
// * Rechercher un article via son id
// * Ajouter un article
// * Modifier un article
// * Supprimer un article
//...

// Remarquez que notre model ( comme tous nos models ) extends de la Database.
// Ainsi, lorsque vous instancier votre model, vous profitez du constructor de Database permettant de se connecter à la BDD.

class Voitures extends Database {

    public function getAllVoitures() {
        $req = "SELECT * FROM voitures ORDER BY annee DESC LIMIT 10";
        return $this->findAll($req);
    }

    public function getVoitureById($id) {
        return $this->getOneById('voitures' , $id);
    }

    public function getAllImagesById($id) {
        return $this->getAllById('imagesdetails', 'voiture_id', $id);
    }

    public function addOneVoiture($data) {
        $this->addOne('voitures',
                        'name, annee, prix, carb_id, trans_id, kilometrage, image_pr, description, cat_id, marq_id, mod_id',
                        '?,?,?,?,?,?,?,?,?,?,?',
                        $data);
    }
    
    public function updateOneVoiture($data, $id) {
        $this->updateOne('voitures',
                          $data,
                        'id',
                        $id);
    }
    
    public function deleteOneVoiture($id){
        $this->deleteOne('voitures',
                           'id',
                         $id);
    }
    
    public function searchVoitures($search){
        $req = "SELECT * FROM voitures WHERE name LIKE ? ORDER BY id DESC";
        return $this->findAll($req, [$search]);
    }
    
}
