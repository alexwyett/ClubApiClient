<?php

/**
 * PHP Client Validation Exception object.
 *
 * PHP Version 5.4
 *
 * @category  Client
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient\client;

/**
 * PHP Client Validation Exception object.
 *
 * @category  Client
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
class ValidationException extends Exception
{
    /**
     * Validation errors array
     * 
     * @var array
     */
    protected $errors = array();
    
    // ------------------ Public Functions --------------------- //

    /**
     * Constructor
     *
     * @param object     $response Api Response
     * @param string     $message  Exception message
     * @param integer    $code     Optional Exception code
     * @param \Exception $previous Optional previous exception
     */
    public function __construct(
        $response,
        $message,
        $code = 0, 
        \Exception $previous = null
    ) {
        // Set overide params
        $this->setDescriptionFromResponse($response, $message['description']);
        $this->setCodeFromResponse($response, $code);
        $this->setErrors($message['errors']);

        parent::__construct(
            $response,
            $this->getApiDescription(),
            $this->getApiCode(),
            $previous
        );
    }
    
    /**
     * Set the validation errors
     * 
     * @param array $errors Errors array
     * 
     * @return \aw\clubapiclient\client\ValidationException
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
        
        return $this;
    }
    
    /**
     * Return the validation errors
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
    
    /**
     * __toString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return parent::__toString() . '.  For more information, catch '
            . 'this exception and call the getErrors method.';
    }
}
