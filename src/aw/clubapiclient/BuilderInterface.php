<?php

/**
 * Rest Crud Interface
 *
 * PHP Version 5.5
 *
 * @category  Interface
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient;

/**
 * Rest Crud Interface
 *
 * @category  Interface
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
interface BuilderInterface
{
    /**
     * Peform a post request
     * 
     * @return $this
     */
    public function create();
    
    /**
     * Peform an update request
     * 
     * @return $this
     */
    public function update();
    
    /**
     * Peform a delete request
     * 
     * @return $this
     */
    public function delete();
    
    /**
     * Array representation of the object
     * 
     * @return array
     */
    public function toArray();
    
    /**
     * Return a string of the url used for create/updates
     * 
     * @return string
     */
    public function getUrlStub();
}
