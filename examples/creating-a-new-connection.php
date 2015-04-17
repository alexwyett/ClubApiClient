<?php

/**
 * This file documents how to create a new api instance object from a
 * club api instance.
 *
 * PHP Version 5.4
 *
 * @category  Examples
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 */

// Include the autoloader
require_once __DIR__ . '/../autoload.php';
require_once 'config.php';

\aw\clubapiclient\client\Client::factory(
    APIURL, // Api Url
    APIKEY, // Api Key
    APISECRET, // Api Secret
    unserialize(APIOPTIONS)
);

$history = new \GuzzleHttp\Subscriber\History();
\aw\clubapiclient\client\Client::getClient()->getEmitter()->attach($history);