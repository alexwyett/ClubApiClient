<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
   if ($id = filter_input(INPUT_GET, 'clubId')) {
        $club = aw\clubapiclient\Club::get($id);
       
        echo sprintf(
            '<h2>%s <small>%s</small></h2>',
            $club->getName(),
            $club->getDescription()
        );
        
        $contacts = $club->getContacts();
        if ($contacts->getTotal() > 0) {
            echo '<h3>Contacts</h3>';
            foreach ($contacts as $contact) {
                echo sprintf('<p>%s</p>', (string) $contact);
            }
        }
        
        $venues = $club->getClubVenues();
        if ($venues->getTotal() > 0) {
            echo '<h3>Plays at:</h3>';
            foreach ($venues as $venue) {
                echo sprintf('<p>%s</p>', (string) $venue->getVenue());
            }
        }
       
   } else {
       echo 'clubId not specified';
   }
        
} catch(Exception $e) {
    echo $e->getMessage();
}