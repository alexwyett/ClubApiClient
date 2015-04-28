<?php

/**
 * Phone number object.
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
 * Phone number object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string          getNumber()               Return the phone number
 * @method TelephoneNumber setNumber(string $number) Set the phone number
 * 
 * @method string          getType()             Return the phone number type
 * @method TelephoneNumber setType(string $type) Set the phone number type
 */

class TelephoneNumber extends Builder
{
    /**
     * Type
     * 
     * @var string
     */
    protected $type = '';
    
    /**
     * Number
     * 
     * @var string
     */
    protected $number = '';
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * @inheritDoc
     */
    public function getCreateUrl()
    {
        return '/contact/' . $this->getParent()->getId() . '/telephonenumber';
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getNumber() . '(' . $this->getType() . ')';
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
            'telephoneNumber' => $this->getNumber(),
            'telephoneNumberType' => $this->getType()
        );
    }
}