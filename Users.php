<?php

namespace Models;

// Notre model Users va nous permettre de stocker toutes nos méthodes permettant de réaliser des requêtes
// SQL liées aux utilisateurs
// * Rechercher tous les utilisateurs
// * Rechercher un utilisateur via son id
// * Ajouter un utilisateur
// * Modifier un utilisateur
// * Supprimer un utilisateur
//...

// Notre model extends lui aussi de la Database.

class Users extends Database {

    public function getAllUsers() {
        $req = "SELECT * FROM users ORDER BY username DESC";
        return $this ->findAll($req);
    }
    
     public function getUserById($id) {
        return $this->getOneById('users' , $id);
    }
    
    public function addOneUser($data) {
        $this->addOne( 'users',
                        'username, user_img, email, password',
                        '?,?,?,?',
                        $data);
    }
    
    public function verifyIfExist($email) {
        $req = "SELECT * FROM users WHERE email = ?";
        return $this->findOne($req, [$email]);
        
         }

    // ...

}



