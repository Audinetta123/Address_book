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


// Routes

 $app->get("/login", function($request, $response) { 
    $name=
    $password=[];












 });






    $app->get('/', function() use($app) {
        echo "Welcome to Address_book API REST designed with Slim 3.0 based API";
    }); 

//GET 

// get all contacts and export in a JSON format

// $app->get('/contacts', function ($request, $response, $args) {
//     $sth = $this->db->prepare("SELECT * FROM contacts");
//     $sth->execute();
//     $contacts = $sth->fetchAll();
//     return $this->response->withJson($contacts);
// });


    $app->get("/contacts", function($request, $response) { 
        $contact = []; 
        $query = $this->db->query("SELECT * FROM contacts ORDER BY id DESC;"); 
        $fetch = $query->fetchAll(); 
        for ($i = 0; $i < sizeof($fetch); $i++) { 
            $contacts[] = ["id" => $fetch[$i]["id"], "civility" => $fetch[$i]["civility"], "surname" => $fetch[$i]["surname"], "date_of_birth" => $fetch[$i]["date_of_birth"], "created_on" => $fetch[$i]["created_on"], "updated_on" => $fetch[$i]["updated_on"]]; } 
            $response->withHeader('Content-type', 'application/json'); 
            return $response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT); });


// get contact with specific id

    $app->get('/contacts/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM contacts WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $contacts = $sth->fetchObject();
        return $this->response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);

    //     $sth = $this->db->prepare("SELECT * FROM addresses WHERE id_contact=:id");
//     $sth->bindParam("id", $args['id']);
//     $sth->execute();
//     $address = $sth->fetchObject();
//     print_r($address);
//     return $this->response->withJson($address);

    });


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

//POST => add a new contact

    $app->post('/contact', function ($request, $response) {

        $input = $request->getParsedBody();
        if (isset($input['civility']) && isset($input['surname']) && isset($input['firstname']) && isset($input['date_of_birth']) && isset($input['password'])) {

            $passwordHash= new PassHash();
            $hash=$passwordHash->hash($input['password']);

       

        // prepare the statement and then methods related to the request can be applied to the query string $sth so the presence of the arrows. 
            $sth=$this->db->prepare("INSERT INTO contacts (civility, surname, firstname, date_of_birth, created_on, updated_on, password_hash, api_key) VALUES (:civility,:surname, :firstname, :date_of_birth, NOW(), NOW() ,:password_hash, :api_key)" );

        // var_dump($sth);

            $sth->bindParam(":civility", $input['civility']);
            $sth->bindParam(":surname", $input['surname']);
            $sth->bindParam(":firstname", $input['firstname']);
            $sth->bindParam(":date_of_birth", $input['date_of_birth']);
            $sth->bindParam(":password_hash", $hash);
            $sth->bindParam(":api_key", md5(uniqid(rand(), true)));

            $sth->execute();


            $output['id'] = $this->db->lastInsertId();


            $data=["error" => false, "message" => "Record has been added to database with id:".$output['id']];
            return $this->response->withJson($data);

        } else {

            $data=["error" => true, "message" => "Error has occured"];
            return $this->response->withJson($data);
        }

    });


//PUT => update contact

// headers:
// args: arguments of the request
// body: where you send the response

    $app->put('/contact/[{id}]', function ($request, $response, $args) {

        $input = $request->getParsedBody();



        if (isset($args['id']) && isset($input['civility']) && isset($input['surname']) && isset($input['firstname']) && isset($input['date_of_birth'])){

            $sth=$this->db->prepare("UPDATE contacts SET civility=:civility, surname=:surname, firstname=:firstname, date_of_birth=:date_of_birth, updated_on=NOW() WHERE id=:id");

            $sth->bindParam(":id", $args['id']);
            $sth->bindParam(":civility", $input['civility']);
            $sth->bindParam(":surname", $input['surname']);
            $sth->bindParam(":firstname", $input['firstname']);
            $sth->bindParam(":date_of_birth", $input['date_of_birth']);

            $sth->execute();

            $data=["error" => false, "message" => "Record with ".$args['id']." has been updated"];
            return $this->response->withJson($data);

        }

        else {

            $data=["error" => true, "message" => "Error has occured"];
            return $this->response->withJson($data);

        }

    });


//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


// DELETE  contact with related address(es)

    $app->delete('/contact/[{id}]', function ($request, $response) {
        $get_id = $request->getAttribute('id');

        $test=$this->db->prepare("SELECT * FROM contacts WHERE id=:id");
        $test->bindParam(':id', $get_id);
        $test->execute();
        $hello=$test->fetch();

        if ($hello!=false) {
            $sth = $this->db->prepare("DELETE FROM contacts WHERE id=$get_id");
            $result=$sth->execute();
        }
        else {
            $result=false;
        }

        return $response->withJson($result==true ? ["error" => false, "message" => "entry has been deleted"] : ["error" => true, "message" => "entry has not been deleted"], 200, JSON_PRETTY_PRINT);
    });

// $app->delete('/contact/[{id}]', function($request, $response, $args) {

//     $json   = json_decode($request->getBody(), true);

//     if ((!isset($json["id"])) || (!is_numeric($json["id"]))) {
//         $data   = ["error" => true, "message" => "Argument id is missing or it's not numeric!"];
//     } else {
//         $id     = (int) $json["id"];
//         $search = $this->db->query("SELECT id FROM contacts WHERE id='{$id}'");
//         $fetch  = $search->fetch();
//         if (isset($fetch["id"])) {
//             $this->db->query("DELETE FROM contacts WHERE id='{$id}'");
//             $data   = ["error" => false, "message" => "contacts has been deleted!"];
//         } else {
//             $data   = ["error" => true, "message" => "contacts not found"];
//         }
//     }
//     $response->withHeader('Content-type', 'application/json');
//     return $response->withJson($data, 200, JSON_PRETTY_PRINT);
// });