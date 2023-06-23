<?php 
namespace Models;

class Imagesdetails extends Database {

    public function getAllImagesdetails() {
        $req = "SELECT * FROM imagesdetails ORDER BY id ASC";
        return $this->findAll($req);
    }
}
