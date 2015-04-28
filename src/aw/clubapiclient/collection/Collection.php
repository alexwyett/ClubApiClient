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
 * 
 * @method Pagination                  getPagination()    Return the pagination element
 * @method \aw\clubapiclient\core\Base getElementParent() Return the element parent
 * 
 * @method Collection setRoute(string $route) Set the route
 */
abstract class Collection extends \aw\clubapiclient\Base implements CollectionInterface, \IteratorAggregate
{
    /**
     * Elements array
     * 
     * @var array
     */
    protected $elements = array();
    
    /**
     * Element parent.  Each child element will have this parent
     * 
     * @var \aw\clubapiclient\Base 
     */
    protected $elementParent;

    /**
     * Pagination object
     * 
     * @var Pagination
     */
    protected $pagination;

    // ------------------ Public Functions --------------------- //
    
    /**
     * Fetch an array of elements
     * 
     * @return \aw\clubapiclient\collection\Collection
     */
    public function fetch()
    {
        // Get the element index
        $class = $this->getElementClass();
        $elementsIndex = \aw\clubapiclient\client\Client::getClient()->get(
            $this->getRoute(),
            $this->getPagination()->toArray()
        );

        if ($elementsIndex
            && $elementsIndex->getStatusCode() == 200
        ) {
            $json = $elementsIndex->json(array('object' => true));
            $elements = $json;
            if (is_object($json) && property_exists($json, 'elements') 
                && property_exists($json, 'total')
            ) {
                $this->pagination->setTotal($json->total);
                $elements = $json->elements;
            } else {
                $this->setTotal(count($elements))->setLimit(count($elements));
            }
            
            // Clear elements array first
            $this->elements = array();
            
            // Populate with new elements
            foreach ($elements as $element) {
                $ele = $class::factory($element);
                if ($this->getElementParent()) {
                    $parent = $this->getElementParent();
                    $ele->setParent($parent);
                }
                $this->addElement($ele);
            }
            
            return $this;
        }
        
        throw new \aw\clubapiclient\client\Exception(
            $elementsIndex,
            'Unable to fetch GET: ' . $class
        );
    }
    
    /**
     * Fetch an array of valid filters
     * 
     * @return stdClass
     */
    public function filters()
    {
        // Get the element index
        $class = $this->getElementClass();
        $elementsIndex = \aw\clubapiclient\client\Client::getClient()->options(
            $this->getRoute()
        );

        if ($elementsIndex
            && $elementsIndex->getStatusCode() == 200
        ) {
            return $elementsIndex->json(array('object' => true));
        }
        
        throw new \aw\clubapiclient\client\Exception(
            $elementsIndex,
            'Unable to fetch OPTIONS: ' . $class
        );
    }
    
    // ------------------ Public Functions --------------------- //
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->pagination = new Pagination();
    }
    
    /**
     * Set the element parent
     * 
     * @param \aw\clubapiclient\Base &$element Element by ref
     * 
     * @return Collection
     */
    public function setElementParent(&$element)
    {
        $this->elementParent = $element;
        
        return $this;
    }
    
    /**
     * Set the elements
     * 
     * @param array $elements Array of elements
     * 
     * @return Collection
     */
    public function setElements(array $elements)
    {
        foreach ($elements as $element) {
            $this->addElement($element);
        }
        
        return $this;
    }
    
    /**
     * Add an element to the collection
     * 
     * @param mixed $element Element to add
     * 
     * @return Collection
     */
    public function addElement(&$element)
    {
        $this->elements[] = $element;
        
        return $this;
    }
    
    /**
     * Remove an element by its id
     * 
     * @param integer $id Element id
     * 
     * @return \aw\clubapiclient\collection\Collection
     */
    public function removeElementById($id)
    {
        foreach ($this->getElements() as $ind => $ele) {
            if ($ele->getId() == $id) {
                unset($this->elements[$ind]);
                break;
            }
        }
        
        return $this;
    }
    
    /**
     * Remove an element by its id
     * 
     * @param \aw\clubapiclient\Base $element Element
     * 
     * @return \aw\clubapiclient\collection\Collection
     */
    public function removeElement(\aw\clubapiclient\Base $element)
    {
        return $this->removeElementById($element->getId());
    }
    
    /**
     * Return the total amount of elements found
     * 
     * @return integer
     */
    public function getTotal()
    {
        // Need to do this check for when elements are added to a new collection
        // after 
        if (count($this->getElements()) > 0 
            && $this->getPagination()->getTotal() == 0
        ) {
            $this->setTotal(count($this->getElements()))
                ->setLimit(count($this->getElements()));
        }
        
        return $this->getPagination()->getTotal();
    }
    
    /**
     * Set the page to query
     * 
     * @param integer $page Page number
     * 
     * @return Collection
     */
    public function setPage($page)
    {
        if (is_numeric($page)) {
            $this->getPagination()->setPage($page);
        }
        
        return $this;
    }
    
    /**
     * Set the limit to query
     * 
     * @param integer $limit Element limit (page size)
     * 
     * @return Collection
     */
    public function setLimit($limit)
    {
        if (is_numeric($limit)) {
            $this->getPagination()->setLimit($limit);
        }
        
        return $this;
    }
    
    /**
     * Set the total
     * 
     * @param integer $total Number of elements found
     * 
     * @return Collection
     */
    public function setTotal($total)
    {
        $this->getPagination()->setTotal($total);
        
        return $this;
    }
    
    /**
     * Set the pagination filters
     * 
     * @param array $filters Filters array
     * 
     * @return Collection
     */
    public function setFilters(array $filters = [])
    {
        $this->getPagination()->setFilters($filters);
        
        return $this;
    }
    
    /**
     * Return the collections elements
     * 
     * @return array
     */
    public function toArray()
    {
        return $this->getElements();
    }
    
    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getElements());
    }
}