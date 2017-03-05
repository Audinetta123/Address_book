<?php


class Addresses {

	public static function addById($input, $idcontact, $iduser){

		$sth = Database::bdd()->prepare("INSERT INTO addresses (street, postal_code, city, created_on, updated_on, id_contact, id_user) VALUES (:street, :postal_code, :city, 
			NOW(), NOW(), :id_contact, :id_user)");

		$sth->bindParam(":street", $input['street']);
		$sth->bindParam(":postal_code", $input['postal_code']);
		$sth->bindParam(":city", $input['city']);
		$sth->bindParam(":id_contact", $idcontact);
		$sth->bindParam(":id_user", $iduser);

		$sth->execute();

		$output['id'] = Database::bdd()->lastInsertId();

		return $data = ["error" => false, "message" => "Address has been added to database with id:".$output['id']];

	}

	public static function getById($id){

		$sth = Database::bdd()->prepare("SELECT * FROM addresses WHERE id = $id");
		$sth->execute();
		
		return $address = $sth->fetchObject();

	}

}