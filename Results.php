<?php

namespace Models;

// Je considère ce model comme une sorte de "four-tout", j'y met toutes mes méthodes que je n'arrive pas à classer :
// * Methode de nettoyage
// * Récupération de la date actuel selon un format et un fuseau horaire précis.
// * Générateur de chaîne aléatoire
//...

// Notre model extends lui aussi de la Database. ( au cas où !!! )

class Results extends Database {

    public function cleaned($data) {
        $data = trim($data);                    // Supprime les espaces (ou d'autres caractères) en début et fin de chaîne
        $data = stripslashes($data);            // Supprime les antislashs d'une chaîne
        $data = htmlspecialchars($data);        // Convertit les caractères spéciaux en entités HTML
        return $data;
    }

    public function dateNow(string $format, string $fuseau) {
        date_default_timezone_set($fuseau);
        $dateActuelle = date_create('now')->format($format);
        return $dateActuelle;
    }

    public function genererChaineAleatoire($longueur = 10) {
        return substr(str_shuffle(str_repeat(
            $code='0123456789ABCDEFGHJKLMNPQRSTVWXYZacefhjkmnrstvwxyz',
            ceil($longueur/strlen($code)) )), 1, $longueur);
    }

    //...
}