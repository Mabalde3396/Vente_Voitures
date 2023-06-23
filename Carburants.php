<?php

namespace Models;


class Carburants extends Database
{
    public function getAllCarburants() {
        $req = "SELECT * FROM carburants ORDER BY carb_name ASC";
        return $this->findAll($req);
    }

    //...
}