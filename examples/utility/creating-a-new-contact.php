<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    echo '<h4>Contact</h4>';
    
    $contact = new aw\clubapiclient\Contact();
    $contact->setFirstName('Testy')
        ->setSurname('Testing')
        ->setRole('Test')
        ->setPrivate(false)
        ->create();
    
    echo $contact->getId();
    
    
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}