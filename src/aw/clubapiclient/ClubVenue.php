<?php

/**
 * ClubVenue object.
 *
 * PHP Version 5.4
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient;

/**
 * ClubVenue object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method Venue      getVenue()     Return the venue
 * @method Timeslot[] getTimeslots() Return the venue timeslots
 */
class ClubVenue extends Builder
{
    /**
     * Venue
     * 
     * @var Venue
     */
    protected $venue;
    
    /**
     * Timeslots
     * 
     * @var Timeslot[]
     */
    protected $timeslots = array();
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * Set the venue
     * 
     * @param Venue|stdClass|array $venue Venue object
     * 
     * @return \aw\clubapiclient\ClubVenue
     */
    public function setVenue($venue)
    {
        $this->venue = Venue::factory($venue);
        $this->venue->setParent($this);
        
        return $this;
    }
    
    /**
     * Add the timeslots to the array
     * 
     * @param array $timeslots Array of timeslot representations
     * 
     * @return \aw\clubapiclient\ClubVenue
     */
    public function setTimeslots(array $timeslots)
    {
        foreach ($timeslots as $_timeslot) {
            $timeslot = Timeslot::factory($_timeslot);
            $this->addTimeslot($timeslot);
        }
        
        return $this;
    }
    
    /**
     * Add a timeslot to the venue
     * 
     * @param \aw\clubapiclient\Timeslot $timeslot Timeslot
     * 
     * @return \aw\clubapiclient\ClubVenue
     */
    public function addTimeslot(Timeslot &$timeslot)
    {
        $timeslot->setParent($this);
        $this->timeslots[] = $timeslot;
        
        return $this;
    }
    
    /**
     * Remove a telephone number
     * 
     * @param \aw\clubapiclient\TelephoneNumber $timeslot Timeslot object
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function removeTimeslot(Timeslot &$timeslot)
    {
        foreach ($this->getTimeslots() as $index => $_ts) {
            if ($timeslot === $_ts) {
                $_ts->delete()->setParent(null);
                unset($this->timeslots[$index]);
            }
        }
        
        return $this;
    }
    
    /**
     * ToArray function.
     * 
     * @return array
     */
    public function toArray()
    {
        return array(
            'id' => $this->getId(),
            'venue_id' => $this->getVenue()->getId()
        );
    }
    
    /**
     * Return simple string representation of a club venue
     * 
     * @return string
     */
    public function __toString()
    {
        $timeSlots = array();
        foreach ($this->getTimeslots() as $ts) {
            $timeSlots[] = (string) $ts;
        }
        return sprintf(
            '%s: %s',
            $this->getVenue()->getName(),
            implode(' ', $timeSlots)
        );
    }
}