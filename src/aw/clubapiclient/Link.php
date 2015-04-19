<?php

/**
 * Link object.
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
 * Link object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string getLink()             Return the link
 * @method Link   setLink(string $link) Set the link
 * 
 * @method string getDescription()             Return the link description
 * @method Link   setDescription(string $desc) Set the link description
 * 
 * @method string getLinkType()             Return the linkType
 * @method Link   setLinkType(string $type) Set the linkType
 */
class Link extends Builder
{
    /**
     * Link
     * 
     * @var string
     */
    protected $link = '';
    
    /**
     * Description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Link type
     * 
     * @var string
     */
    protected $linkType = '';
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getLink();
    }
    
    /**
     * @inheritDoc
     */
    public function getCreateUrl()
    {
        return $this->getClass();
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
            'link' => $this->getLink(),
            'description' => $this->getDescription(),
            'linkType' => $this->getLinkType()
        );
    }
}