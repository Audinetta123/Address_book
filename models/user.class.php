<?php

class Users {

	
	public static function register($input, $hash) {

		$base = new Database();

		$bdd = $base->bdd();

		$sth = $bdd->prepare("INSERT INTO users (surname, firstname, password_hash, api_key) VALUES (:surname, :firstname, :password_hash, :api_key)");

		$sth->bindParam(":surname", $input['surname']);
		$sth->bindParam(":firstname", $input['firstname']);
		$sth->bindParam(":password_hash", $hash);
		$sth->bindParam(":api_key", md5(uniqid(rand(), true)));

		$sth->execute();

		$output = $bdd->lastInsertId();

		return $data = ["error" => false, "message" => "user has been added to database with id:".$output];

	}

	public static function loginCheckPassword($input) {

		$sth = Database::bdd()->prepare("SELECT password_hash FROM users WHERE surname = :surname");
		$sth->bindParam("surname", $input['surname']);
		$sth->execute();

		return $response  = $sth->fetchObject();

	}

	public static function loginCheckApiKey($input) {

		$apiKey = Database::bdd()->prepare("SELECT api_key FROM users WHERE surname = :surname");
		$apiKey->bindParam("surname", $input['surname']);
		$apiKey->execute();
		$apiKeyResult  = $apiKey->fetchObject();

		return $data=["error" => false, "apiKey" => $apiKeyResult->api_key];

	}


}