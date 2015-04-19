<?php

/**
 * Collection object.
 *
 * PHP Version 5.4
 *
 * @category  Collection
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient\collection;

/**
 * Collection object. Handles groups of objects output from
 * a fetch command.
 *
 * @category  Collection
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
abstract class StaticCollection extends Collection
{
    /**
     * Stop fetch requests
     * 
     * @throws \aw\clubapiclient\client\Exception
     */
    public function fetch()
    {
        throw new \aw\clubapiclient\client\Exception(
            null,
            'Fetch not allow for Static collections',
            -1
        );
    }
    
    /**
     * Stop filter requests
     * 
     * @throws \aw\clubapiclient\client\Exception
     */
    public function filters()
    {
        throw new \aw\clubapiclient\client\Exception(
            null,
            'Filters not allow for Static collections',
            -1
        );
    }
    
    /**
     * @inheritDoc
     */
    public function getRoute()
    {
        return '';
    }
}