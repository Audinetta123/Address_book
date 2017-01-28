<?php


// Routes

$app->post("/register", function($request, $response) {


 $input = $request->getParsedBody();
 if (isset($input['surname']) && isset($input['firstname']) && isset($input['password'])) {

    $passwordHash = new PassHash();
    $hash = $passwordHash->hash($input['password']);

        // test if username is already used?
    $query = $this->db->prepare("SELECT * FROM users WHERE surname = :surname");
    $query->bindParam("surname", $input['surname']);
    $query->execute();
    $queryUsername  = $query->fetchObject();
    $row = $query->rowCount();

    if (0 < $row) {

        $data = ["error" => true, "message" => "Error has occured => Username ".$queryUsername->surname." already exists. Choose another name."];

        return $this->response->withJson($data);

    } else {

            // prepare the statement and then methods related to the request can be applied to the query string $sth so the presence of the arrows. 
        $sth = $this->db->prepare("INSERT INTO users (surname, firstname, password_hash, api_key) VALUES (:surname, :firstname, :password_hash, :api_key)");

        $sth->bindParam(":surname", $input['surname']);
        $sth->bindParam(":firstname", $input['firstname']);
        $sth->bindParam(":password_hash", $hash);
        $sth->bindParam(":api_key", md5(uniqid(rand(), true)));

        $sth->execute();

        $output['id'] = $this->db->lastInsertId();


        $data = ["error" => false, "message" => "user has been added to database with id:".$output['id']];

        return $this->response->withJson($data);

    }

} else {

    $data = ["error" => true, "message" => "Error has occured"];

    return $this->response->withJson($data);
    
}

});


$app->post("/login", function($request, $response) {

    $input = $request->getParsedBody();

    if (isset($input['surname']) && isset($input['password'])) {

        $sth = $this->db->prepare("SELECT password_hash FROM users WHERE surname = :surname");
        $sth->bindParam("surname", $input['surname']);
        $sth->execute();
        $passwordHash  = $sth->fetchObject();

        $passwordHashCheck = new PassHash();
        $passwordCheck = $passwordHashCheck->check_password($passwordHash->password_hash, $input['password']);

        if ($passwordCheck == true) {
           $apiKey = $this->db->prepare("SELECT api_key FROM users WHERE surname = :surname");
           $apiKey->bindParam("surname", $input['surname']);
           $apiKey->execute();
           $apiKeyResult  = $apiKey->fetchObject();

           $data=["error" => false, "message" => "user is logged-in successfully => API key is : ".$apiKeyResult->api_key];

           return $this->response->withJson($data);

       }

       else {

        $data = ["error" => true, "message" => "bad entry => user is not registered"];

        return $this->response->withJson($data,401);

    }   
}
});

$app->get('/', function() use($app) {
    echo "Welcome to Address_book API REST designed with Slim 3.0 based API";

}); 

//GET all contacts

$app->get("/contacts", function($request, $response) { 
    $contact = []; 
    $query = $this->db->query("SELECT * FROM contacts ORDER BY id ASC;"); 
    $fetch = $query->fetchAll(); 
    for ($i = 0; $i < sizeof($fetch); $i++) { 
        $contacts[] = ["id" => $fetch[$i]["id"], "civility" => $fetch[$i]["civility"], "surname" => $fetch[$i]["surname"], "date_of_birth" => $fetch[$i]["date_of_birth"], "created_on" => $fetch[$i]["created_on"], "updated_on" => $fetch[$i]["updated_on"]]; } 
        $response->withHeader('Content-type', 'application/json'); 

        return $response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT); });


// GET contact with specific id

$app->get('/contacts/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM contacts WHERE id = :id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $contacts = $sth->fetchObject();

    return $this->response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);

});

// GET address with specific id

$app->get('/addresses/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM addresses WHERE id = :id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $address = $sth->fetchObject();

    return $this->response->withJson(!empty($address) ? $address : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);

});


//POST => add a new contact

$app->post('/contact', function ($request, $response) {

    $api = verifApi($this->db);

    $input = $request->getParsedBody();

    if (1 == $api['exist']) {

        if (!empty($input['civility']) && !empty($input['surname']) && !empty($input['firstname']) && !empty($input['date_of_birth'])) {

        // prepare the statement and then methods related to the request can be applied to the query string $sth so the presence of the arrows. 
            $sth = $this->db->prepare("INSERT INTO contacts (civility, surname, firstname, date_of_birth, created_on, updated_on, id_user) VALUES (:civility,:surname, :firstname, :date_of_birth, NOW(), NOW(), :id_user)");

        // var_dump($sth);

            $sth->bindParam(":civility", $input['civility']);
            $sth->bindParam(":surname", $input['surname']);
            $sth->bindParam(":firstname", $input['firstname']);
            $sth->bindParam(":date_of_birth", $input['date_of_birth']);
            $sth->bindParam(":id_user", $api['idUser']);

            $sth->execute();

            $output['id'] = $this->db->lastInsertId();


            $data = ["error" => false, "message" => "Record has been added to database with id:".$output['id']];

            return $this->response->withJson($data,201);

        } else {

            $data = ["error" => true, "message" => "Error has occured -> verify input fields"];

            return $this->response->withJson($data,400);

        }

    } else {

        $data = ["error" => true, "message" => "apiKey is not valid"];

        return $this->response->withJson($data,401);

    }

});


//PUT => update contact

$app->put('/contact/[{id}]', function ($request, $response, $args) {

    $result = verifUser($this->db, $args['id']);

    $input = $request->getParsedBody();

    if ($result) {

        if (isset($args['id']) && isset($input['civility']) && isset($input['surname']) && isset($input['firstname']) && isset($input['date_of_birth'])){

            $sth2 = $this->db->prepare("UPDATE contacts SET civility=:civility, surname = :surname, firstname = :firstname, date_of_birth = :date_of_birth, updated_on = NOW() WHERE id = :id");

            $sth2->bindParam(":id", $args['id']);
            $sth2->bindParam(":civility", $input['civility']);
            $sth2->bindParam(":surname", $input['surname']);
            $sth2->bindParam(":firstname", $input['firstname']);
            $sth2->bindParam(":date_of_birth", $input['date_of_birth']);

            $sth2->execute();

            $data = ["error" => false, "message" => "Record with id: ".$args['id']." has been updated"];

            return $this->response->withJson($data);

        }

        else {

            $data = ["error" => true, "message" => "Error has occured"];

            return $this->response->withJson($data, 401);

        }

    }
    else {

        $data = ["error" => true, "message" => "Verify three of the followings: 1 => apiKey is not valid or 2 => id does not exist in database or 3 => verify id has been created with contact of correct apiKey"];

        return $this->response->withJson($data,401);

    }



});

//POST an address

$app->post('/address/[{id}]', function ($request, $response, $args) {

    $result = verifUser($this->db, $args['id']);

    $input = $request->getParsedBody();

    if ($result) {

       if (!empty($input['postal_code']) && !empty($input['city'])) {

        $sth = $this->db->prepare("INSERT INTO addresses (street, postal_code, city, created_on, updated_on, id_contact) VALUES (:street, :postal_code, :city, 
            NOW(), NOW(), :id_contact)");

        $sth->bindParam(":street", $input['street']);
        $sth->bindParam(":postal_code", $input['postal_code']);
        $sth->bindParam(":city", $input['city']);
        $sth->bindParam(":id_contact", intval($result['id']));

        $sth->execute();

        $output['id'] = $this->db->lastInsertId();

        $data = ["error" => false, "message" => "Address has been added to database with id:".$output['id']];

        return $this->response->withJson($data,201);

    }

    else {
        $data = ["error" => true, "message" => "Error has occured -> verify input fields"];

        return $this->response->withJson($data,400);

    }
}

else {

    $data = ["error" => true, "message" => "Verify three of the followings: 1 => apiKey is not valid or 2 => id does not exist in database or 3 => verify id has been created with contact of correct apiKey"];

    return $this->response->withJson($data,401);

}

});

// DELETE  contact with related address(es) -> only contact by correct user (the one that created the contact) can be deleted

$app->delete('/contact/[{id}]', function ($request, $response, $args) {

    $result = verifUser($this->db, $args['id']);

    if ($result) {

        $sth = $this->db->prepare("DELETE FROM contacts WHERE id = :id");
        $sth->bindParam(':id', $args['id']);
        $result = $sth->execute();

    }
    
    else {

        $result = false;

    }

    return $response->withJson($result == true ? ["error" => false, "message" => "entry with id ".$args['id']." was deleted"] : ["error" => true, "message" => "entry with id ".$args['id']." was not deleted -> check whether contact specified initially existed or was created by other user"], 200, JSON_PRETTY_PRINT);
});

// ALTER TABLE addresses AUTO_INCREMENT = 1
