<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    echo '<h4>Links</h4>';
    $links = new \aw\clubapiclient\collection\Link();
    echo implode(', ', $links->fetch()->getElements());
    
    $link = new \aw\clubapiclient\Link();
    $link->setLink('http://www.google.com')->setLinkType('website')->create();
    
    echo '<h4>Created Links</h4>';
    $links2 = new \aw\clubapiclient\collection\Link();
    echo implode(', ', $links2->fetch()->getElements());
    
    $link->setLink('http://www.google.co.uk')->update();
    
    echo '<h4>Updated Links</h4>';
    $links3 = new \aw\clubapiclient\collection\Link();
    echo implode(', ', $links3->fetch()->getElements());
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}