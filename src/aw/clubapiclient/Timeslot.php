<?php

/**
 * Timeslot object.
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
 * Timeslot object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string   getFromTime()             Return the starting time
 * @method Timeslot setFromTime(string $time) Set the starting time
 * 
 * @method string   getTillTime()             Return the finish time
 * @method Timeslot setTillTime(string $time) Set the finish time
 * 
 * @method string   getDescription()             Return the description
 * @method Timeslot setDescription(string $desc) Set the description
 * 
 * @method TimeslotDay getDay() Return the day
 */
class Timeslot extends Builder
{
    /**
     * From time
     * 
     * @var string
     */
    protected $fromTime = '';
    
    /**
     * Till time
     * 
     * @var string
     */
    protected $tillTime = '';
    
    /**
     * Description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Link type
     * 
     * @var TimeslotDay
     */
    protected $day;
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * Set the day
     * 
     * @param array|stdClass\TimeslotDay $day Day object
     * 
     * @return \aw\clubapiclient\Timeslot
     */
    public function setDay($day)
    {
        $this->day = TimeslotDay::factory($day);
        
        return $this;
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getDescription()
            . ': ' . $this->getFromTime() 
            . ' to ' 
            . $this->getTillTime()
            . ' every ' . $this->getDay()->getDay();
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
            'fromTime' => $this->getFromTime(),
            'tillTime' => $this->getTillTime(),
            'description' => $this->getDescription(),
            'dayNumber' => $this->getDay()->getDayNumber()
        );
    }
}