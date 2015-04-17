<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    echo '<h4>Tags</h4>';
    $tags = new \aw\clubapiclient\collection\Tag();
    echo implode(', ', $tags->fetch()->getElements());
    
    $tag = new \aw\clubapiclient\Tag();
    $tag->setName('test')->create();
    
    echo '<h4>Created Tags</h4>';
    $tags2 = new \aw\clubapiclient\collection\Tag();
    echo implode(', ', $tags2->fetch()->getElements());
    
    $tag->setName('Updated test')->update();
    
    echo '<h4>Updated Tags</h4>';
    $tags3 = new \aw\clubapiclient\collection\Tag();
    echo implode(', ', $tags3->fetch()->getElements());
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}