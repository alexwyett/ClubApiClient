<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    echo '<h4>Titles</h4>';
    $titles = new \aw\clubapiclient\collection\Title();
    echo implode(', ', $titles->fetch()->getElements());
    
    echo '<h4>Tags</h4>';
    $tags = new \aw\clubapiclient\collection\Tag();
    echo implode(', ', $tags->fetch()->getElements());
    
    echo '<h4>Links</h4>';
    $links = new \aw\clubapiclient\collection\Link();
    echo implode(', ', $links->fetch()->getElements());
    
    echo '<h4>Days</h4>';
    $days = new \aw\clubapiclient\collection\TimeslotDay();
    echo implode(', ', $days->fetch()->getElements());
    
    echo '<h4>Clubs</h4>';
    $clubs = new \aw\clubapiclient\collection\Club();
    foreach ($clubs->fetch()->getElements() as $club) {
        echo sprintf(
            '<p><a href="requesting-club-data.php?clubId=%s">%s</a></p>',
            $club->getId(),
            $club->getName()
        );
    }
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}