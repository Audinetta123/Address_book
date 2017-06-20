<?php


class Addresses {

	public static function addById($input, $idcontact, $iduser){

		$base = new Database();

		$bdd = $base::bdd();

		$sth = $bdd->prepare("INSERT INTO addresses (street, postal_code, city, created_on, updated_on, id_contact, id_user) VALUES (:street, :postal_code, :city, 
			NOW(), NOW(), :id_contact, :id_user)");

		$sth->bindParam(":street", $input['street']);
		$sth->bindParam(":postal_code", $input['postal_code']);
		$sth->bindParam(":city", $input['city']);
		$sth->bindParam(":id_contact", $idcontact);
		$sth->bindParam(":id_user", $iduser);

		$sth->execute();

		$output['id'] = $bdd->lastInsertId();

		return $data = ["error" => false, "message" => "Address has been added to database with id:".$output['id']];

	}

	public static function getById($idContact, $idUser){

		$sth = Database::bdd()->prepare("SELECT * FROM addresses WHERE id_contact = $idContact AND id_user = $idUser ");
		$sth->execute();
		
		return $address = $sth->fetchAll();

	}

}