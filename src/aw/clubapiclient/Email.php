<?php

/**
 * Email object.
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
 * Email object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string getEmail()              Return the Email
 * @method Email  setEmail(string $email) Set the Email
 */

class Email extends Builder
{   
    /**
     * Email
     * 
     * @var string
     */
    protected $email = '';
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * @inheritDoc
     */
    public function getCreateUrl()
    {
        return '/contact/' . $this->getParent()->getId() . '/email';
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getEmail();
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
            'email' => $this->getEmail()
        );
    }
}