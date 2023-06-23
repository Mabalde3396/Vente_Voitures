<?php

namespace Models;



class Transmissions extends Database
{
    public function getAllTransmissions() {
        $req = "SELECT * FROM transmissions ORDER BY trans_name ASC";
        return $this->findAll($req);
    }

    //...
}