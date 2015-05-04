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
            foreach ($contacts->getElements() as $contact) {
                echo sprintf('<p>%s</p>', (string) $contact);
            }
        }
        
        $venues = $club->getClubVenues();
        if ($venues->getTotal() > 0) {
            echo '<h3>Plays at:</h3>';
            foreach ($venues->getElements() as $venue) {
                echo sprintf('<p>%s</p>', (string) $venue->getVenue());
            }
        }
       
   } else {
       
        $clubs = new aw\clubapiclient\collection\Club();
        $clubs->setLimit(filter_input(INPUT_GET, 'limit'))
            ->setPage(filter_input(INPUT_GET, 'page'))
            ->fetch();
        echo '<h2>' . $clubs->getTotal() . ' found</h2>';
        
        $pager = $clubs->getPagination();
        foreach ($clubs->getElements() as $club) {
            echo sprintf(
                '<p><a href="requesting-club-data.php?clubId=%s">%s</a></p>',
                $club->getId(),
                (string) $club
            );
        }
        echo sprintf(
            '<p><a href="?page=%s&limit=%s">Previous</a>',
            $pager->getPrevPage(),
            $pager->getLimit()
        );
        
        echo ' | ';
        echo sprintf(
            '<a href="?page=%s&limit=%s">Next</a></p>',
            $pager->getNextPage(),
            $pager->getLimit()
        );
       
   }
        
} catch(Exception $e) {
    echo $e->getMessage();
}