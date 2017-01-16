<?php


// Routes

$app->post("/register", function($request, $response) {


   $input = $request->getParsedBody();
   if (isset($input['surname']) && isset($input['firstname']) && isset($input['password'])) {

    $passwordHash= new PassHash();
    $hash=$passwordHash->hash($input['password']);

        // prepare the statement and then methods related to the request can be applied to the query string $sth so the presence of the arrows. 
    $sth=$this->db->prepare("INSERT INTO users (surname, firstname, password_hash, api_key) VALUES (:surname, :firstname,:password_hash, :api_key)" );

        // var_dump($sth);

    $sth->bindParam(":surname", $input['surname']);
    $sth->bindParam(":firstname", $input['firstname']);
    $sth->bindParam(":password_hash", $hash);
    $sth->bindParam(":api_key", md5(uniqid(rand(), true)));

    $sth->execute();

    $output['id'] = $this->db->lastInsertId();


    $data=["error" => false, "message" => "user has been added to database with id:".$output['id']];
    return $this->response->withJson($data);

} else {

    $data=["error" => true, "message" => "Error has occured"];
    return $this->response->withJson($data);
}

});


$app->post("/login", function($request, $response) {
    $input = $request->getParsedBody();

    if (isset($input['surname']) && isset($input['password'])) {

        $sth = $this->db->prepare("SELECT password_hash FROM users WHERE surname=:surname");
        $sth->bindParam("surname", $input['surname']);
        $sth->execute();
        $passwordHash  = $sth->fetchObject();

        $passwordHashCheck= new PassHash();
        $passwordCheck=$passwordHashCheck->check_password($passwordHash->password_hash, $input['password']);

        if ($passwordCheck==true) {
         $api_key=$this->db->prepare("SELECT api_key FROM users WHERE surname=:surname");
         $api_key->bindParam("surname", $input['surname']);
         $api_key->execute();
         $api_key_result  = $api_key->fetchObject();

         $data=["error" => false, "message" => "user is logged-in successfully => api_key: ".$api_key_result->api_key];
         return $this->response->withJson($data);
     }

     else {

        $data=["error" => true, "message" => "bad entry => user is not registered"];
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
    $query = $this->db->query("SELECT * FROM contacts ORDER BY id DESC;"); 
    $fetch = $query->fetchAll(); 
    for ($i = 0; $i < sizeof($fetch); $i++) { 
        $contacts[] = ["id" => $fetch[$i]["id"], "civility" => $fetch[$i]["civility"], "surname" => $fetch[$i]["surname"], "date_of_birth" => $fetch[$i]["date_of_birth"], "created_on" => $fetch[$i]["created_on"], "updated_on" => $fetch[$i]["updated_on"]]; } 
        $response->withHeader('Content-type', 'application/json'); 
        return $response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT); });


// GET contact with specific id

$app->get('/contacts/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM contacts WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $contacts = $sth->fetchObject();
    return $this->response->withJson(!empty($contacts) ? $contacts : ["error" => true, "message" => "No records found in database"], 200, JSON_PRETTY_PRINT);
});


//POST => add a new contact

$app->post('/contact', function ($request, $response) {

    $api=verifApi($this->db);

    $input = $request->getParsedBody();

    if ($api['exist']==1) {

        if (!empty($input['civility']) && !empty($input['surname']) && !empty($input['firstname']) && !empty($input['date_of_birth'])) {

        // prepare the statement and then methods related to the request can be applied to the query string $sth so the presence of the arrows. 
            $sth=$this->db->prepare("INSERT INTO contacts (civility, surname, firstname, date_of_birth, created_on, updated_on, id_user) VALUES (:civility,:surname, :firstname, :date_of_birth, NOW(), NOW(), :id_user)");

        // var_dump($sth);


            $sth->bindParam(":civility", $input['civility']);
            $sth->bindParam(":surname", $input['surname']);
            $sth->bindParam(":firstname", $input['firstname']);
            $sth->bindParam(":date_of_birth", $input['date_of_birth']);
            $sth->bindParam(":id_user", $api['idUser']);

            $sth->execute();

            $output['id'] = $this->db->lastInsertId();


            $data=["error" => false, "message" => "Record has been added to database with id:".$output['id']];
            return $this->response->withJson($data,201);

        } else {

            $data=["error" => true, "message" => "Error has occured / verify input fields"];
            return $this->response->withJson($data,400);
        }

    } else {

        $data=["error" => true, "message" => "apiKey is not valid"];
        return $this->response->withJson($data,401);
    }

});


//PUT => update contact

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
