<?php

/**
 * Contact collection object.
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
 * Contact collection object.
 *
 * @category  Collection
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
class ClubContact extends StaticCollection
{
    /**
     * Return an array of Contact objects.  This object will need to be
     * instantiated and the method fetch will need to be called before this will
     * return any elements.
     *
     * @return \aw\clubapiclient\Contact[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @inheritDoc
     */
    public function getElementClass()
    {
        return '\aw\clubapiclient\Contact';
    }
}
