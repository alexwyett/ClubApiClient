<?php

/**
 * Client builder helper object.
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
 * Client builder helper object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
abstract class Builder extends Base implements BuilderInterface
{

    // -------------------------- Public Functions -------------------------- //
    
    /**
     * Perform a create request
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return Builder
     */
    public function create()
    {
        // Perform post request
        $req = \aw\clubapiclient\client\Client::getClient()->post(
            $this->getCreateUrl(),
            $this->toCreateArray()
        );

        if (!$req
            || $req->getStatusCode() !== '201'
        ) {
            throw new \aw\clubapiclient\client\Exception(
                $req,
                'Unable to create ' . ucfirst($this->getClass())
            );
        }
        
        // Set the id of the element
        $id = self::getRequestId($req);
        if ($id) {
            $this->setId(
                (integer) $id
            );
        }
        
        return $this;
    }
    
    /**
     * Perform a update request
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return Builder
     */
    public function update()
    {
        // Perform put request
        $req = \aw\clubapiclient\client\Client::getClient()->put(
            $this->getUpdateUrl(),
            $this->toUpdateArray()
        );

        if (!$req
            || $req->getStatusCode() !== '204'
        ) {
            throw new \aw\clubapiclient\client\Exception(
                $req,
                'Unable to update ' . ucfirst($this->getClass())
            );
        }
        
        return $this;
    }
    
    /**
     * Perform a update request without any parameters
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return Builder
     */
    public function commit()
    {
        // Perform put request
        $req = \aw\clubapiclient\client\Client::getClient()->put(
            $this->getUpdateUrl()
        );

        if (!$req
            || $req->getStatusCode() !== '204'
        ) {
            throw new \aw\clubapiclient\client\Exception(
                $req,
                'Unable to commit ' . ucfirst($this->getClass())
            );
        }
        
        return $this;
    }
    
    /**
     * Perform a create request
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return Builder
     */
    public function delete()
    {
        // Perform delete request
        $req = \aw\clubapiclient\client\Client::getClient()->delete(
            $this->getUpdateUrl()
        );

        if (!$req
            || $req->getStatusCode() !== '204'
        ) {
            throw new \aw\clubapiclient\client\Exception(
                $req,
                'Unable to delete ' . ucfirst($this->getClass())
            );
        } else {
            if ($this->getParent()) {
                $this->parent = null;
            }
        }
        
        return $this;
    }
    
    /**
     * Generate a url string for a create url
     * 
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->_createUrl();
    }
    
    /**
     * Generate a url string for a update url
     * 
     * @return string
     */
    public function getUpdateUrl()
    {
        return $this->_updateUrl();
    }
    
    /**
     * @inheritDoc
     */
    public function getUrlStub()
    {
        return strtolower($this->getClass());
    }
    
    /**
     * Helpful accessor incase structure of create post is different to the
     * toArray map
     * 
     * @return array
     */
    public function toCreateArray()
    {
        return $this->toArray();
    }
    
    /**
     * Helpful accessor incase structure of update put is different to the
     * toArray map
     * 
     * @return array
     */
    public function toUpdateArray()
    {
        return $this->toArray();
    }

    /**
     * Generate a url string for a create url
     * 
     * @param string $prefix Prefix
     * 
     * @return string
     */
    private function _createUrl($prefix = '')
    {
        if ($this->getParent()) {
            $prefix = $this->getParent()->_updateUrl(
                $prefix
            );
        }
        return $prefix . '/' . $this->getUrlStub();
    }
    
    /**
     * Generate a url string for a create url
     * 
     * @param string $prefix Prefix
     * 
     * @return string
     */
    private function _updateUrl($prefix = '')
    {
        if ($this->getParent()) {
            $prefix = $this->getParent()->_updateUrl(
                $prefix
            );
        }
        
        return $prefix . '/' . $this->getUrlStub() . '/' . $this->getId();
    }
}