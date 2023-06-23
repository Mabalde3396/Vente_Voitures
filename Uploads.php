<?php

namespace Models;

// Notre model Uploads va nous permettre de stocker toutes nos méthodes relatives à l'upload de fichiers

const UPLOADS_DIR = 'public/uploads/';                  // UPLOADS_DIR Répertoire ou seront uploadés les fichiers
const FILE_EXT_IMG = ['jpg','jpeg','gif','png', 'JPG']; // FILE_EXT_IMG  extensions acceptées pour les images
const MIME_TYPES = [
                        'png' => 'image/png',
                        'jpeg' => 'image/jpeg',
                        'jpg' => 'image/jpeg'
];

class Uploads {

    /** Déplace un fichier transmis dans un répertoire du serveur
    * @param $file - Contenu du tableau $_FILES à l'index du fichier à uploader
    * @param $errors - La variable devant contenir les erreurs. Passage par référence
    * @param $folder - Chemin absolue ou relatif où le fichier sera déplacé. Par default UPLOADS_DIR
    * @param $fileExtensions - Un tableau d'extensions valident - Par défaut vaut FILE_EXT_IMG.
    *
    * @return array - Un tableau contenant les erreurs (ou vide) ou un string avec le nom du fichier securisé pour pouvoir travailler dans la base de données..
    */
    public function upload(array $file, string $dossier = '', array &$errors, string $folder = UPLOADS_DIR, array $fileExtensions = FILE_EXT_IMG) {
        $filename = '';

        if ($file["error"] === UPLOAD_ERR_OK) {
            $tmpName = $file["tmp_name"];

            // On récupère l'extension du fichier pour vérifier si elle est dans  $fileExtensions
            $tmpNameArray = explode(".", $file["name"]);
            $tmpExt = end($tmpNameArray);
            if(in_array($tmpExt, $fileExtensions)) {
                // basename() peut empêcher les attaques de système de fichiers en supprimant les éventuels répertoire dans le nom
                // la validation/assainissement supplémentaire du nom de fichier peut être appropriée
                // On donne un nouveau nom au fichier
                $filename = uniqid().'-'.basename($file["name"]);

                if(!move_uploaded_file($tmpName, $folder.$dossier."/".$filename))
                    $errors[] = "Le fichier n'a pas été enregistré correctement";

                // mime_content_type - Détecte le type de contenu d'un fichier.
                // On vérifie le contenue de fichier, pour voir s'il appartient aux MIMES autorises.
                if(!in_array(mime_content_type($folder.$dossier."/".$filename), MIME_TYPES, true))
                    $errors[] = "Le fichier n'a pas été enregistré correctement !";
            }
            else {
                $errors[] = "Ce type de fichier n'est pas autorisé !";
            }
        }
        else if($file["error"] == UPLOAD_ERR_INI_SIZE || $file["error"] == UPLOAD_ERR_FORM_SIZE) {
            // UPLOAD_ERR_INI_SIZE - La taille du fichier téléchargé excède la valeur de upload_max_filesize, configurée dans le php.ini.
            // UPLOAD_ERR_FORM_SIZE - La taille du fichier téléchargé excède la valeur de MAX_FILE_SIZE, qui a été spécifiée dans le formulaire HTML.
            $errors[] = 'Le fichier est trop volumineux';
        }
        else {
            $errors[] = "Une erreur a eu lieu au moment de l'upload";
        }
        return $filename;
    }
}