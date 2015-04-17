<?php

/**
 * Rest API Base object.
 *
 * PHP Version 5.4
 *
 * @category  API_Client
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient;

/**
 * Rest API Base object.
 *
 * Provides setter/getter methods for all child classes.
 *
 * PHP Version 5.4
 *
 * @category  API_Client
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
abstract class Base
{
    /**
     * Id
     * 
     * @var integer
     */
    protected $id;
    
    /**
     * Parent element
     *
     * @var \aw\clubapiclient\Base
     */
    protected $parent;

    // ------------------ Static Functions --------------------- //

    /**
     * Get an object from a given route
     *
     * @param string $route GET route
     *
     * @return mixed
     */
    public static function _get($route)
    {
        $request = \aw\clubapiclient\client\Client::getClient()->get($route);

        return self::factory($request->json(array('object' => true)));
    }
    
    /**
     * Fetch an array of elements
     * 
     * @param string $route Url to fetch
     * 
     * @return array
     */
    public static function _fetch($route)
    {
        // Get the route
        $request = \aw\clubapiclient\client\Client::getClient()->get($route);
        $elements = array();

        if ($request
            && $request->getStatusCode() == '200'
        ) {
            $json = $request->json(array('object' => true));
            foreach ($json as $element) {
                $ele = static::factory($element);
                array_push($elements, $ele);
            }
            
            return $elements;
        }
        
        throw new \aw\clubapiclient\client\Exception(
            $request,
            'Unable to fetch element for route: ' . $route
        );
    }
    
    /**
     * Return the ID from a content-location header
     * 
     * @param \GuzzleHttp\Message\Response $req Guzzle response
     * 
     * @return string|void
     */
    public static function getRequestId($req)
    {
        if ($req->getHeader('content-location')) {
            return self::getIdFromString($req->getHeader('content-location'));
        } else {
            return;
        }
    }
    
    /**
     * Return an id from a url string
     * 
     * @param string $str String
     * 
     * @return string
     */
    public static function getIdFromString($str)
    {
        $location = explode('/', $str);

        return $location[count($location) - 1];
    }

    /**
     * Return the name of the class which calls this method
     *
     * @return string
     */
    public static function getClass()
    {
        $type = explode('\\', get_called_class());

        return $type[count($type) - 1];
    }

    /**
     * Create a new object
     *
     * @param array|stdClass|Base $element Representation of the object
     *
     * @return Base
     */
    public static function factory($element)
    {
        // If class is the same as object being `factory'ised`, just return it.
        if (is_object($element) && get_class($element) == get_called_class()) {
            return $element;
        }
            
        $object = new static();
        self::setObjectProperties($object, $element);

        return $object;
    }

    /**
     * Helper function foor setting object properties
     *
     * @param object $obj        Generic object passed by reference
     * @param object $node       Node object to iterate through
     * @param array  $exceptions Properties to ignore
     *
     * @return void
     */
    public static function setObjectProperties(&$obj, $node, $exceptions = array())
    {
        foreach ($node as $key => $val) {
            $func = 'set' . ucfirst($key);
            if (!in_array($key, $exceptions) 
                && (property_exists($obj, $key) || method_exists($obj, $func))
            ) {
                $obj->$func($val);
            }
        }
    }

    // -------------------------- Public Functions -------------------------- //
    
    /**
     * Check if a method exists or not.  If a magic method accessor is specified
     * then the method will check the property string after the accessor 
     * prefix (i.e. set or get).
     * 
     * @param string $method Method name
     * 
     * @return boolean
     */
    public function method_exists($method)
    {
        if (!is_string($method)) {
            return false;
        }
        
        if (method_exists($this, $method)) {
            return true;
        }
        
        if ((substr($method, 0, 3) == 'get' || substr($method, 0, 3) == 'set')
            && property_exists($this, lcfirst(substr($method, 3)))
        ) {
            return true;
        }
        
        return false;
    }

    /**
     * Convert a boolean value to a string
     * 
     * @param boolean $boolean Boolean value
     * 
     * @return string
     */
    public function boolToStr($boolean)
    {
        return ($boolean === true) ? 'true' : 'false';
    }
    
    /**
     * Set the parent element
     *
     * @param \aw\clubapiclient\Base $element Parent element
     *
     * @return \aw\clubapiclient\Base
     */
    public function setParent(&$element)
    {
        $this->parent = $element;

        return $this;
    }

    /**
     * Return the builder parent element
     *
     * @return \aw\clubapiclient\Base
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    /**
     * Returns the object id
     * 
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * Set the id
     * 
     * @param integer $id Id
     * 
     * @return \aw\clubapiclient\Base
     */
    public function setId($id)
    {
        $this->id = $id;
        
        return $this;
    }
    
    /**
     * Recursive finder function.  Traverses up the tree to try to
     * find a perent object with a matching class.
     * 
     * @param string $type Class type
     * 
     * @return Base|null
     */
    public function findParentByType($type)
    {
        if ($this->getParent() && $type == $this->getParent()->getClass()) {
            return $this->getParent();
        } else if ($this->getParent()) {
            return $this->getParent()->findParentByType($type);
        } else {
            return;
        }
    }

    /**
     * Generic getter/setter
     *
     * @param string $name Name of property
     * @param array  $args Function arguments
     *
     * @return void
     */
    public function __call($name, $args = array())
    {
        // This call method is only for accessors
        if (strlen($name) > 3) {
            // Get the property
            $property = substr($name, 3, strlen($name));

            // All properties will be camelcase, make first letter lowercase
            $property[0] = strtolower($property[0]);

            if (property_exists($this, $property)) {
                switch (substr($name, 0, 3)) {
                    case 'set':
                        $this->setObjectProperty($this, $property, $args[0]);
                        return $this;
                    break;
                    case 'get':
                        return $this->$property;
                }
            }
        }

        throw new \aw\clubapiclient\client\Exception(
            null,
            'Unknown method called:' . get_called_class() . ':' . $name
        );
    }

    /**
     * Get magic method.  Added for symfony forms.
     *
     * @param string $name Name of property
     *
     * @throws \aw\clubapiclient\client\Exception
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
    }

    /**
     * Get magic method.  Added for symfony forms.
     *
     * @param string $name Name of property
     *
     * @throws \aw\clubapiclient\client\Exception
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        if (property_exists($this, $name)) {
            $this->setObjectProperty($this, $name, $value);
        }
    }

    // ------------------------- Protected Functions ------------------------ //

    /**
     * Generic setter
     *
     * @param object $obj      Generic object to set properties
     * @param string $property Property of object to set
     * @param mixed  $value    Value of property
     *
     * @return void
     */
    protected function setObjectProperty($obj, $property, $value)
    {
        switch (strtolower(gettype($obj->$property))) {
        case 'array':
        case 'integer':
        case 'object':
        case 'null':
        case 'resource':
            $obj->$property = $value;
            break;
        case 'boolean':
            if (is_bool($value)) {
                $obj->$property = $value;
            }
            break;
        case 'string':
            $obj->$property = trim($value);
            break;
        case 'float':
            $obj->setFloatVal($value, $property);
            break;
        }
    }

    /**
     * Generic float setter
     *
     * @param float  $float   Float val needed to set to variable
     * @param string $varName Variable name
     *
     * @return void
     */
    protected function setFloatVal($float, $varName)
    {
        if (strpos($float, '.') < strpos($float, ',')) {
            $float = str_replace('.', '', $float);
            $float = strtr($float, ',', '.');
        } else {
            $float = str_replace(',', '', $float);
        }
        if (is_numeric(floatval($float))) {
            $this->$varName = floatval($float);
        }
    }
    
    /**
     * Return a date time object from a given param
     * 
     * @param string|\DateTime $date Date object
     * 
     * @return \DateTime
     */
    public function getDateTime($date)
    {
        if (!$date instanceof \DateTime) {
            $date = new \DateTime($date);
        }
        
        return $date;
    }    
}