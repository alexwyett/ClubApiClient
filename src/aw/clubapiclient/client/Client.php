<?php

/**
 * API client object.
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
 * API client object.
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
class Client extends \GuzzleHttp\Client
{
    /**
     * Static api instance
     *
     * @var \aw\clubapiclient\client\Client
     */
    static $instance;
    
    /**
     * HMAC plugin
     * 
     * @var \aw\clubapiclient\client\Hmac 
     */
    protected $hmac;

    /**
     * Create a new Api Connection for use within the tabs php client
     * api.
     *
     * @param string $baseUrl Url of the api
     * @param string $key     API Key
     * @param string $secret  HMAC Secret Key
     * @param array  $config  Configuration settings
     *
     * @return \aw\clubapiclient\client\Client
     */
    public static function factory(
        $baseUrl,
        $key = '',
        $secret = '',
        $config = array()
    ) {
        self::$instance = new static($baseUrl, $key, $secret, $config);
        return self::$instance;
    }

    /**
     * Get the client
     *
     * @return \aw\clubapiclient\client\Client
     */
    public static function getClient()
    {
        // Check for an existing api object
        if (!self::$instance) {
            throw new Exception(null, 'No api connection available');
        }

        return self::$instance;
    }
    
    /**
     * Contructor
     * 
     * @param string $baseUrl Url of the api
     * @param string $key     API Key
     * @param string $secret  HMAC Secret Key
     * @param array  $config  Configuration settings
     *
     * @throws RuntimeException if cURL is not installed
     * 
     * @return void
     */
    public function __construct($baseUrl, $key, $secret, $config = array())
    {
        $plugin = new \aw\clubapiclient\client\Hmac($key, $secret);
        $this->hmac = $plugin;
        
        if (isset($config['prefix'])) {
            $plugin->setPrefix($config['prefix']);
            unset($config['prefix']);
        }
        
        parent::__construct(
            array_merge(
                array('base_url' => $baseUrl),
                $config
            )
        );
        $this->getEmitter()->attach($plugin);
    }
    
    /**
     * Return the hmac plugin
     * 
     * @return \aw\clubapiclient\client\Hmac
     */
    public function getHmac()
    {
        return $this->hmac;
    }
    
    /**
     * Overriden get request
     * 
     * @param string $url     Api URL
     * @param array  $params  Query Parameters
     * @param array  $options Client options
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function get($url = null, $params = [], $options = [])
    {
        return $this->sendRequest(
            $this->createQueryRequest('get', $url, $params, $options)
        );
    }
    
    /**
     * Overriden delete request
     * 
     * @param string $url     Api URL
     * @param array  $params  Query Parameters
     * @param array  $options Client options
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function delete($url = null, array $params = [], array $options = [])
    {
        return $this->sendRequest(
            $this->createQueryRequest('delete', $url, $params, $options)
        );
    }
    
    /**
     * Overriden options request
     * 
     * @param string $url     Api URL
     * @param array  $params  Query Parameters
     * @param array  $options Client options
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function options($url = null, array $params = [], array $options = [])
    {
        return $this->sendRequest(
            $this->createQueryRequest('options', $url, $params, $options)
        );
    }
    
    /**
     * Overriden post request
     * 
     * @param string $url     Api URL
     * @param array  $params  POST Parameters
     * @param array  $options Client options
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function post($url = null, array $params = [], array $options = [])
    {
        return $this->sendRequest(
            $this->createPostRequest('post', $url, $params, $options)
        );
    }
    
    /**
     * Overriden put request
     * 
     * @param string $url     Api URL
     * @param array  $params  POST Parameters
     * @param array  $options Client options
     * 
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function put($url = null, array $params = [], array $options = [])
    {
        return $this->sendRequest(
            $this->createPostRequest('put', $url, $params, $options)
        );
    }
    
    /**
     * Create a new guzzle request and append params onto the
     * request query.
     *
     * @param string     $method  HTTP method (GET, POST, PUT, etc.)
     * @param string|Url $url     HTTP URL to connect to
     * @param array      $params  Key/val array of parameters
     * @param array      $options Array of options to apply to the request
     *
     * @return RequestInterface
     */
    public function createQueryRequest(
        $method,
        $url,
        array $params = [],
        array $options = []
    ) {
        $options['query'] = $params;
        return $this->createRequest($method, $url, $options);
    }
    
    /**
     * Create a new guzzle request and append params onto the
     * request body.
     *
     * @param string     $method  HTTP method (GET, POST, PUT, etc.)
     * @param string|Url $url     HTTP URL to connect to
     * @param array      $params  Key/val array of parameters
     * @param array      $options Array of options to apply to the request
     *
     * @return RequestInterface
     */
    public function createPostRequest(
        $method,
        $url,
        array $params = [],
        array $options = []
    ) {
        $options['body'] = $params;
        return $this->createRequest($method, $url, $options);
    }
    
    /**
     * Perform request.
     * 
     * @param RequestInterface $request Guzzle request object
     * 
     * @return \GuzzleHttp\Message\Response
     */
    public function sendRequest($request)
    {
        try {
            return $this->send($request);
        } catch (\RuntimeException $ex) {
            $this->_setException($ex);
        }
    }    
    
    /**
     * Handle a put/post request exception
     * 
     * @param \RuntimeException $exception Exception object
     * 
     * @throws \aw\clubapiclient\client\ValidationException
     * @throws \aw\clubapiclient\client\Exception
     * 
     * @return void
     */
    private function _setException($exception)
    {
        $json = $exception->getResponse()->json();
        switch ($json['errorType']) {
            case 'ValidationException':
                throw new \aw\clubapiclient\client\ValidationException(
                    $exception,
                    \json_decode($json['errorDescription'], true),
                    $json['errorCode']
                );
            default:
                throw new \aw\clubapiclient\client\Exception(
                    $exception,
                    $json['errorDescription'],
                    $json['errorCode']
                );
        }
    }
}
