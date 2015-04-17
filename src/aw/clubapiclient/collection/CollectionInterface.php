<?php

/**
 * Collection Interface
 *
 * PHP Version 5.4
 *
 * @category  Interface
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient\collection;

/**
 * Collection Interface
 *
 * @category  Interface
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
interface CollectionInterface
{
    /**
     * Return the elements of the collection
     * 
     * @return array
     */
    public function getElements();
    
    /**
     * Return the route which will provide the collection information
     * 
     * @return string
     */
    public function getRoute();
    
    /**
     * Return the class of the collections elements
     * 
     * @return string
     */
    public function getElementClass();
}
