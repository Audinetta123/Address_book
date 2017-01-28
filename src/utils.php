<?php  

// call PassHash hashes password with an encrypting algorithm
class PassHash { 

// blowfish 
    private static $algo = '$2a'; 

// cost parameter 
    private static $cost = '$10'; 

// mainly for internal use 
    public static function unique_salt() { 
        return substr(sha1(mt_rand()), 0, 22); 
    } 

// this will be used to generate a hash 
    public static function hash($password) { 
        return crypt($password, self::$algo . self::$cost . '$' . self::unique_salt()); 
    } 

// this will be used to compare a password against a hash 
    public static function check_password($hash, $password) { 
        $full_salt = substr($hash, 0, 29); $new_hash = crypt($password, $full_salt); return ($hash == $new_hash); 
    } 

}

function verifApi($database){

    $headers = apache_request_headers();
    $api["key"] = $headers["Authorization"];
    $verifkey = $database->prepare("SELECT * FROM users WHERE api_key = :apikey");
    $verifkey->bindParam(":apikey", $api["key"]);
    $verifkey->execute();
    $api["exist"] = $verifkey->rowCount();

    if ($api["exist"] === 1) {
     $id = $database->prepare("SELECT id FROM users WHERE api_key = :apikey");
     $id->bindParam(":apikey", $api['key']);
     $id->execute();
     $apig = $id->fetchObject();
     $api["idUser"] = intval($apig->id);
 }

 return $api;
}

function verifUser($database, $idContact){

    $api = verifApi($database);

    $getId = $idContact;

    $idUser = $api["idUser"];
  
    $sth = $database->prepare("SELECT * FROM contacts WHERE id = :idUser");
    $sth->bindParam(':idUser', $getId);
    $sth->execute();
    $result = $sth->fetch();

    if ($result && $idUser == intval($result["id_user"]) && 1 == $api['exist']) {

       return $result;
    
    }

    else {

        return false;
  

}

}
