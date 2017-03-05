
<?php

class Contacts {
	
	public static function display() {

		$query = Database::bdd()->query("SELECT * FROM contacts ORDER BY id ASC;"); 
		return $fetch = $query->fetchAll();

	}

	public static function displayById($id) {

		$sth = Database::bdd()->prepare("SELECT * FROM contacts WHERE id = $id");
		$sth->execute();
		return $contacts = $sth->fetchObject();
		
	}

	public static function add($input, $iduser){

		$sth = Database::bdd()->prepare("INSERT INTO contacts (civility, surname, firstname, date_of_birth, created_on, updated_on, id_user) VALUES (:civility,:surname, :firstname, :date_of_birth, NOW(), NOW(), :id_user)");

		$sth->bindParam(":civility", $input['civility']);
		$sth->bindParam(":surname", $input['surname']);
		$sth->bindParam(":firstname", $input['firstname']);
		$sth->bindParam(":date_of_birth", $input['date_of_birth']);
		$sth->bindParam(":id_user", $iduser);
		$sth->execute();

		// $output['id'] = Database::bdd()->lastInsertId();
		$output['id'] = $sth->id;

		return $data = ["error" => false, "message" => "Record has been added to database with id:".$output['id']];

	}

	public static function updateById($input, $id){

		$sth = Database::bdd()->prepare("UPDATE contacts SET civility=:civility, surname = :surname, firstname = :firstname, date_of_birth = :date_of_birth, updated_on = NOW() WHERE id = :id");

		$sth->bindParam(":id", $id);
		$sth->bindParam(":civility", $input['civility']);
		$sth->bindParam(":surname", $input['surname']);
		$sth->bindParam(":firstname", $input['firstname']);
		$sth->bindParam(":date_of_birth", $input['date_of_birth']);

		$sth->execute();

		return $data = ["error" => false, "message" => "Record with id: ".$id." has been updated"];
		
	}

	public static function deleteById($id){

		$sth = Database::bdd()->prepare("DELETE FROM contacts WHERE id = $id");
		return $sth->execute();

	}

}