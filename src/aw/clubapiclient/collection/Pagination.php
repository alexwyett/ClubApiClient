<?php

/**
 * API Pagination object.
 *
 * PHP Version 5.4
 *
 * @category  Utility
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

namespace aw\clubapiclient\collection;

/**
 * API Pagination object.
 * 
 * @category  Utility
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */
class Pagination extends \aw\clubapiclient\Base
{
    /**
     * Admin page number
     *
     * @var integer
     */
    protected $page = 1;
    
    /**
     * Admin page size/limit number
     *
     * @var integer
     */
    protected $limit = 10;

    /**
     * Total amount of bookings found for the query
     *
     * @var integer
     */
    protected $total = 0;
    
    /**
     * Current filters
     * 
     * @var array
     */
    protected $filters = array();

    // ------------------ Public Functions --------------------- //
    
    /**
     * Page number setter
     * 
     * @param integer $page Page number
     * 
     * @return \aw\clubapiclient\collection\Pagination
     */
    public function setPage($page)
    {
        $this->page = $page;
        
        return $this;
    }
    
    /**
     * Page limit setter
     * 
     * @param integer $limit Page size/limit
     * 
     * @return \aw\clubapiclient\collection\Pagination
     */
    public function setLimit($limit)
    {
        $this->limit = $limit;
        
        return $this;
    }
    
    /**
     * Total setter
     * 
     * @param integer $total Total
     * 
     * @return \aw\clubapiclient\collection\Pagination
     */
    public function setTotal($total)
    {
        $this->total = $total;
        
        return $this;
    }
    
    /**
     * Set the request filters
     * 
     * @param array $filters Request filters
     * 
     * @return \aw\clubapiclient\collection\Pagination
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
        
        return $this;
    }
    
    /**
     * Return the current page
     * 
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }
    
    /**
     * Return the current page size/limit
     * 
     * @return integer
     */
    public function getLimit()
    {
        return $this->limit;
    }
    
    /**
     * Return the total
     * 
     * @return integer
     */
    public function getTotal()
    {
        return $this->total;
    }
    
    /**
     * Return the filters array
     * 
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }
    
    /**
     * Get the filters string read for a request
     * 
     * @return string
     */
    public function getFiltersString()
    {
        return http_build_query($this->getFilters(), null, ':');
    }
    
    /**
     * Get the filters string ready for a request
     * 
     * @return string
     */
    public function getRequestQuery()
    {
        return http_build_query(
            $this->toArray(),
            null,
            '&'
        );
    }
    
    /**
     * ToArray function
     * 
     * @return array
     */
    public function toArray()
    {
        return array_filter(
            array(
                'page' => $this->getPage(),
                'limit' => $this->getLimit(),
                'filter' => urldecode($this->getFiltersString())
            )
        );
    }

    /**
     * Return the max page int
     *
     * @return integer
     */
    public function getMaxPages()
    {
        return ceil($this->getTotal() / $this->getLimit());
    }

    /**
     * Get the start of the selection
     *
     * @return int
     */
    public function getStart()
    {
        if ($this->getPage() <= 1) {
            return 1;
        } else {
            return (($this->getPage()-1) * $this->getLimit()) + 1;
        }
    }

    /**
     * Get the end of the selection
     *
     * @return integer
     */
    public function getEnd()
    {
        $end = ($this->getStart() - 1) + $this->getLimit();
        if ($end > $this->getTotal()) {
            return $this->getTotal();
        } else {
            return $end;
        }
    }

    /**
     * Get perious page integer
     *
     * @return integer
     */
    public function getPrevPage()
    {
        $page = $this->getPage();
        $prevPage = $page - 1;
        
        return ($prevPage < 1) ? 1 : $prevPage;
    }

    /**
     * Get next page integer
     *
     * @return integer
     */
    public function getNextPage()
    {
        $page = $this->getPage();
        $nextPage = $page + 1;
        
        return ($nextPage > $this->getMaxPages()) ? 1 : $nextPage;
    }

    /**
     * Return the range of pages in the selection
     *
     * @return array
     */
    public function getRange($numPages = 5)
    {
        if ($this->getMaxPages() > 1) {
            
            $rangeStart = 1;
            $rangeEnd = $this->getMaxPages();

            // If $numPages is set and is less than the maximum number of pages
            // in the search, then start to slice up the range of pages
            if ($numPages > 0
                && $this->getMaxPages() > $numPages
            ) {
                // Find middle of numPages
                $rangePad = floor($numPages / 2);

                // Set start and end.
                $rangeStart = $this->getPage() - $rangePad;
                $rangeEnd = $this->getPage() + $rangePad;

                // If the start of the range is out of bounds, reset the bounds
                if ($rangeStart < 1) {
                    $rangeStart = 1;
                    $rangeEnd = $numPages;
                }
            }
            
            return range($rangeStart, $rangeEnd);
        } else {
            return array(1);
        }
    }
}