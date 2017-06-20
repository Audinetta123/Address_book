<?php

class DataBase {
    public  function bdd() {
        $host   = "localhost";
        $base   = "addressBook";
        $login  = "root";
        $pass    = "root";
        try {
            $bdd = new PDO('mysql:host='. $host .';dbname='. $base, $login, $pass);
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        } catch (Exception $e) {
            die('Erreur : '. $e->getMessage());
        }
        return $bdd;
    }

    public function lastInsertId(){
        return $this->bdd()->lastInsertId();
    }

}