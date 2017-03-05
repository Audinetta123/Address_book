<?php
    class DataBase {
        public static function bdd() {
            $host   = "localhost";
            $base   = "address_book";
            $login  = "root";
            $pass    = "aude";
            try {
                $bdd = new PDO('mysql:host='. $host .';dbname='. $base, $login, $pass);
                $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            } catch (Exception $e) {
                die('Erreur : '. $e->getMessage());
            }
            return $bdd;
        }
    }