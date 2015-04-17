<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    $address = new \aw\clubapiclient\Address();
    $address->setLine1('Pangle Cottage')
        ->setLine2('Church Path')
        ->setLine3('Wretton')
        ->setTown('Kings Lynn')
        ->setCounty('Norfolk')
        ->setPostcode('PE33 9QR');
    
    $venue = new \aw\clubapiclient\Venue();
    $venue->setName('Home')
        ->setAddress($address)
        ->create();
    
    echo \aw\clubapiclient\Venue::get($venue->getId())->getName();
    
    
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}