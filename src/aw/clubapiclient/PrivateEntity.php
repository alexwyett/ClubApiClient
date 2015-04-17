<?php

/**
 * Abstract object.
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
 * Abstract object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method boolean       getPrivate()              Return the published bool
 * @method PrivateEntity setPrivate(boolean $bool) Set the published bool
 */
abstract class PrivateEntity extends PublishedEntity
{
    /**
     * Private bool
     * 
     * @var string
     */
    protected $private = false;
    
    /**
     * Return true if entity is private
     * 
     * @return boolean
     */
    public function isPrivate()
    {
        return !$this->getPrivate();
    }
}