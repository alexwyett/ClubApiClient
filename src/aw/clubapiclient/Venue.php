<?php

/**
 * Venue object.
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
 * Venue object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string getName()             Return the venue name
 * @method Venue  setName(string $name) Set the venue name
 * 
 * @method Address getAddress() Return the venue address
 */
class Venue extends PrivateEntity
{
    /**
     * Name
     * 
     * @var string
     */
    protected $name = '';
    
    /**
     * Address
     * 
     * @var string
     */
    protected $address;
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * Venue
     * 
     * @param integer $id Venue id
     * 
     * @return Venue
     */
    public static function get($id)
    {
        return self::_get('venue/' . $id);
    }
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->address = new Address();
    }
    
    /**
     * Set the address
     * 
     * @param Address|stdClass|arra $addr Address object
     * 
     * @return \aw\clubapiclient\Venue
     */
    public function setAddress($addr)
    {
        $this->address = Address::factory($addr);
        $this->address->setParent($this);
        
        return $this;
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName() . ', ' . (string) $this->getAddress();
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
            'name' => $this->getName(),
            'address' => $this->getAddress()->toArray(),
            'published' => $this->boolToStr($this->getPublished()),
            'private' => $this->boolToStr($this->getPrivate())
        );
    }
}