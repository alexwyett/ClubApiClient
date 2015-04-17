<?php

/**
 * Timeslot Day object.
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
 * Timeslot Day object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string      getDay()            Return the day
 * @method TimeslotDay setDay(string $day) Set the day
 * 
 * @method string      getDayNumber()                Return the day number
 * @method TimeslotDay setDayNumber(integer $dayNum) Set the day number
 */
class TimeslotDay extends Base
{
    /**
     * Day
     * 
     * @var string
     */
    protected $day = '';
    
    /**
     * Till time
     * 
     * @var string
     */
    protected $dayNumber = '';
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getDay();
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
            'day' => $this->getDay(),
            'dayNumber' => $this->getDayNumber()
        );
    }
}