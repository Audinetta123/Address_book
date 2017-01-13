<?php
// Routes


//GET 

// get all contacts and export in a JSON format

$app->get('/contacts', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM contacts");
    $sth->execute();
    $contacts = $sth->fetchAll();
    return $this->response->withJson($contacts);
});


// get contact with specific id

$app->get('/contact/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM contacts WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $contact = $sth->fetchObject();


    if($contact) {
        print_r($contact);
        return $this->response->withJson($contact);

    } else {
        throw new PDOException('No records found.');
    }
    
});

//POST => update contact by adding an address or new address for example






//PUT => add a new contact

// $app = new Slim();
// $app->add(new Slim_Middleware_ContentTypes());

// $app->post('/addContact', function () use ($app) {

// }

// echo 'OK';
// $sql = $app->request()->getBody();
// $sql = "INSERT INTO contacts (contact) VALUES (:contact)";
// $sth = $this->db->prepare($sql);
// $sth->bindParam("contact", $input['contact']);
// $sth->execute();
// $input['id'] = $this->db->lastInsertId();
// return $this->response->withJson($input);
// });




// DELETE   



$app->delete('/deleteContact/[{id}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("DELETE FROM contacts WHERE id=:id");
    $sth->bindParam("id", $args['id']);
    $sth->execute();
    $contacts = $sth->fetchAll();
    return $this->response->withJson($contacts);
});






