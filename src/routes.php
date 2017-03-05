<?php


// Routes

// API entry point

$app->get('/', function ($request, $response, $args) {
    return $response->getBody()->write("Welcome to Address_book API REST designed with Slim 3.0 based API!");
});

// user registration

$app->post("/register", function($request, $response) {

 $input = $request->getParsedBody();

 if (isset($input['surname']) && isset($input['firstname']) && isset($input['password'])) {

    $passwordHash = new PassHash();
    $hash = $passwordHash->hash($input['password']);

        // test if username is already used?
    $userExists = verifUserExists($this->db, $input['surname']);

    if (0 < $userExists) {

        $data = ["error" => true, "message" => "Error has occured => Username".$queryUsername->surname." already exists. Choose another name."];

        return $this->response->withJson($data);

    } else {

        $newUser = new Users();

        $data = $newUser->register($input, $hash);

        return $this->response->withJson($data);

    }

} else {

    $data = ["error" => true, "message" => "Error has occured"];

    return $this->response->withJson($data);
    
}

});

// user connection

$app->post("/login", function($request, $response) {

    $input = $request->getParsedBody();

    if (isset($input['surname']) && isset($input['password'])) {

        // $sth = $this->db->prepare("SELECT password_hash FROM users WHERE surname = :surname");
        // $sth->bindParam("surname", $input['surname']);
        // $sth->execute();
        // $passwordHash  = $sth->fetchObject();

        $passwordHash  = Users::loginCheckPassword($input);

        $passwordHashCheck = new PassHash();
        $passwordCheck = $passwordHashCheck->check_password($passwordHash->password_hash, $input['password']);

        if ($passwordCheck == true) {
           // $apiKey = $this->db->prepare("SELECT api_key FROM users WHERE surname = :surname");
           // $apiKey->bindParam("surname", $input['surname']);
           // $apiKey->execute();
           // $apiKeyResult  = $apiKey->fetchObject();

           // $data=["error" => false, "message" => "user is logged-in successfully => API key is : ".$apiKeyResult->api_key];

           $data = Users::loginCheckApiKey($input);

           return $this->response->withJson($data);

       }

       else {

        $data = ["error" => true, "message" => "bad entry => user is not registered"];

        return $this->response->withJson($data,401);

    }   
}
});


//GET all contacts

$app->get("/contacts", function($request, $response) { 

    $contact = []; 
    $fetch = Contacts::display(); 

    for ($i = 0; $i < sizeof($fetch); $i++) { 
        $contacts[] = ["id" => $fetch[$i]["id"], "civility" => $fetch[$i]["civility"], "surname" => $fetch[$i]["surname"], "date_of_birth" => $fetch[$i]["date_of_birth"], "created_on" => $fetch[$i]["created_on"], "updated_on" => $fetch[$i]["updated_on"]]; } 
        $response->withHeader('Content-type', 'application/json'); 

        return $response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT); });


// GET contact with specific id

$app->get('/contacts/[{id}]', function ($request, $response, $args) {

    $contacts = Contacts::displayById($args['id']);

    return $this->response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);

});


//POST => add a new contact

$app->post('/contact', function ($request, $response) {

    $api = verifApi($this->db);

    $input = $request->getParsedBody();

    if (1 == $api['exist']) {

        if (!empty($input['civility']) && !empty($input['surname']) && !empty($input['firstname']) && !empty($input['date_of_birth'])) { 

            $data = Contacts::add($input, $api['idUser']);

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

            $data = Contacts::updateById($input ,$args['id']);

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

// DELETE  contact with related address(es) -> only contact by correct user (the one that created the contact) can be deleted

$app->delete('/contact/[{id}]', function ($request, $response, $args) {

    $result = verifUser($this->db, $args['id']);

    if ($result) {

        $result = Contacts::deleteById($args['id']);
        var_dump($result);

    }
    
    else {

        $result = false;

    }

    return $response->withJson($result == true ? ["error" => false, "message" => "entry with id ".$args['id']." was deleted"] : ["error" => true, "message" => "entry with id ".$args['id']." was not deleted -> check whether contact specified initially existed or was created by other user or API key correctly specified"], 200, JSON_PRETTY_PRINT);
});

//POST an address

$app->post('/address/[{id}]', function ($request, $response, $args) {

    $result = verifUser($this->db, $args['id']);

    $input = $request->getParsedBody();

    if ($result) {

       if (!empty($input['postal_code']) && !empty($input['city'])) {

        $data = Addresses::addById($input, intval($result['id']), intval($result['id_user']));

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

// GET address with specific id

$app->get('/addresses/[{id}]', function ($request, $response, $args) {

    $address = Addresses::getById(intval($args['id']));

    return $this->response->withJson(!empty($address) ? $address : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);

});

// ALTER TABLE addresses AUTO_INCREMENT = 1
