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
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}