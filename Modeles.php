<?php

namespace Models;


class Modeles extends Database
{
    public function getAllModeles() {
        $req = "SELECT * FROM modeles ORDER BY mod_name ASC";
        return $this->findAll($req);
    }

    //...
}