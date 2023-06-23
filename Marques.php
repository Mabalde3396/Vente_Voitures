<?php

namespace Models;


class Marques extends Database {

    public function getAllMarques() {
        $req = "SELECT * FROM marques ORDER BY marq_name DESC";
        return $this->findAll($req);
    }
}