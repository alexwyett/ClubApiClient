<?php

// Include the connection
require_once __DIR__ . '/../creating-a-new-connection.php';

try {
    
    $timeSlot = new aw\clubapiclient\Timeslot();
    $day = new aw\clubapiclient\TimeslotDay();
    $day->setDayNumber(2)->setDay('Wednesday');
    
    $timeSlot->setDay($day)
        ->setFromTime('6.30pm')
        ->setTillTime('9pm')
        ->setDescription('Club night')
        ->create();
    
    echo $timeSlot->getId();
        
} catch(Exception $e) {
    echo $e->getMessage();

var_dump((string) $history);
}