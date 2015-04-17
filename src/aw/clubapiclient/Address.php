<?php

/**
 * Tabs Rest Address object.
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
 * Tabs Rest Address object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * 
 * @method string  getLine1()     Return the Address line 1
 * @method string  getLine2()     Return the Address line 2
 * @method string  getLine3()     Return the Address line 3
 * @method string  getTown()      Return the Address town
 * @method string  getCounty()    Return the Address county
 * @method string  getPostcode()  Return the Address postcode
 * @method float   getLongitude() Return the longitude
 * @method float   getLatitude()  Return the latitude
 * 
 * @method Address setLine1($str)     Set the line number 1
 * @method Address setLine2($str)     Set the line number 2
 * @method Address setLine3($str)     Set the line number 3
 * @method Address setTown($str)      Set the town
 * @method Address setCounty($str)    Set the county
 * @method Address setPostcode($str)  Set the postcode
 * @method Address setLongitude($str) Set the longitude
 * @method Address setLatitude($str)  Set the latitude
 */
class Address extends Base
{
    /**
     * Address line 1
     * 
     * @var string
     */
    protected $line1 = '';
    
    /**
     * Address line 2
     * 
     * @var string
     */
    protected $line2 = '';
    
    /**
     * Address line 3
     * 
     * @var string
     */
    protected $line3 = '';
    
    /**
     * Address town
     * 
     * @var string
     */
    protected $town = '';
    
    /**
     * Address county
     * 
     * @var string
     */
    protected $county = '';
    
    /**
     * Address postcode
     * 
     * @var string
     */
    protected $postcode = '';
    
    /**
     * Address longitude
     * 
     * @var string
     */
    protected $longitude = 0;
    
    /**
     * Address latitude
     * 
     * @var string
     */
    protected $latitude = 0;
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return implode(
            ', ',
            array_filter(
                $this->toArray(),
                function ($ele) {
                    return (gettype($ele) == 'string' && $ele !== '');
                }
            )
        );
    }
    
    /**
     * Array representation of the address.  Used for creates/updates.
     * 
     * @return array
     */
    public function toArray()
    {
        return array(
            'line1' => $this->getLine1(),
            'line2' => $this->getLine2(),
            'line3' => $this->getLine3(),
            'town' => $this->getTown(),
            'county' => $this->getCounty(),
            'postcode' => $this->getPostcode(),
            'longitude' => (float) $this->getLongitude(),
            'latitude' => (float) $this->getLatitude()
        );
    }
}