<?php

namespace Models;

// Notre model Categories va nous permettre de stocker toutes nos méthodes permettant de réaliser des requêtes
// SQL liées aux catégories
// * Rechercher tous les catégories
// * Rechercher une catégorie via son id
// * Ajouter une catégorie
// * Modifier une catégorie
// * Supprimer une catégorie
//...

// Notre model extends lui aussi de la Database.

class Categories extends Database
{
    public function getAllCategories() {
        $req = "SELECT * FROM categories ORDER BY cat_name ASC";
        return $this->findAll($req);
    }

    //...
}