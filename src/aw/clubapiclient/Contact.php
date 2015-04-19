<?php

/**
 * Contact object.
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
 * Contact object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method Title   getTitle()                Get the title
 * 
 * @method string  getFirstName()             Get the first name
 * @method Contact setFirstName(string $name) Set the first name
 * 
 * @method string  getSurname()             Get the surname
 * @method Contact setSurname(string $name) Set the surname
 * 
 * @method string  getRole()             Get the role
 * @method Contact setRole(string $role) Set the role
 * 
 * @method Address getAddress()       Return the venue address
 * 
 * @method Email[] getContactEmails() Return the contacts emails
 * 
 * @method TelephoneNumber[] getTelephoneNumbers() Return the telephone numbers
 */
class Contact extends PrivateEntity
{
    /**
     * Title
     * 
     * @var Title
     */
    protected $title;
    
    /**
     * First name
     * 
     * @var string
     */
    protected $firstName = '';
    
    /**
     * Surname
     * 
     * @var string
     */
    protected $surname = '';
    
    /**
     * Role
     * 
     * @var string
     */
    protected $role = '';
    
    /**
     * Address
     * 
     * @var string
     */
    protected $address;
    
    /**
     * Contact emails
     * 
     * @var Email[]
     */
    protected $contactEmails = array();
    
    /**
     * Telephone numbers
     * 
     * @var TelephoneNumber[]
     */
    protected $telephoneNumbers = array();


    // ------------------ Public Functions --------------------- //
    
    /**
     * Contact factory method
     * 
     * @param integer $id Venue id
     * 
     * @return Venue
     */
    public static function get($id)
    {
        return self::_get('contact/' . $id);
    }
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $title = new Title();
        $title->setTitle('Mr');
        
        $this->title = $title;
        $this->address = new Address();
    }
    
    /**
     * Set the title
     * 
     * @param array|stdClass|Title $title Title object
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function setTitle($title)
    {
        $this->title = Title::factory($title);
        
        return $this;
    }
    
    /**
     * Set the address
     * 
     * @param Address|stdClass|arra $addr Address object
     * 
     * @return \aw\clubapiclient\Venue
     */
    public function setAddress($addr)
    {
        $this->address = Address::factory($addr);
        $this->address->setParent($this);
        
        return $this;
    }
    
    /**
     * Set the contact emails
     * 
     * @param array $emails Emails array
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function setContactEmails($emails)
    {
        foreach ($emails as $_email) {
            $email = Email::factory($_email);
            
            $this->addContactEmail($email);
        }
        
        return $this;
    }
    
    /**
     * Add a contact email
     * 
     * @param Email $email Email
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function addContactEmail(Email &$email)
    {
        $email->setParent($this);
        $this->contactEmails[] = $email;
        
        return $this;
    }
    
    /**
     * Remove a contact email
     * 
     * @param \aw\clubapiclient\Email $email Email object
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function removeContactEmail(Email &$email)
    {
        foreach ($this->getContactEmails() as $index => $_email) {
            if ($email === $_email) {
                $_email->delete()->setParent(null);
                unset($this->contactEmails[$index]);
            }
        }
        
        return $this;
    }
    
    /**
     * Set the contact numbers
     * 
     * @param array $numbers Numbers array
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function setTelephoneNumbers(array $numbers)
    {
        foreach ($numbers as $_number) {
            $number = TelephoneNumber::factory($_number);
            
            $this->addTelephoneNumber($number);
        }
        
        return $this;
    }
    
    /**
     * Add a telephone number
     * 
     * @param TelephoneNumber $num Telephone number object
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function addTelephoneNumber(TelephoneNumber &$num)
    {
        $num->setParent($this);
        $this->telephoneNumbers[] = $num;
        
        return $this;
    }
    
    /**
     * Remove a telephone number
     * 
     * @param \aw\clubapiclient\TelephoneNumber $num Telephone number object
     * 
     * @return \aw\clubapiclient\Contact
     */
    public function removeTelephoneNumber(TelephoneNumber &$num)
    {
        foreach ($this->getTelephoneNumbers() as $index => $_num) {
            if ($num === $_num) {
                $_num->delete()->setParent(null);
                unset($this->telephoneNumbers[$index]);
            }
        }
        
        return $this;
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return implode(
            ' ',
            array(
                $this->getTitle()->getTitle(),
                $this->getFirstName(),
                $this->getSurname(),
                ' - ' . $this->getRole()
            )
        );
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
            'title' => $this->getTitle()->getTitle(),
            'firstName' => $this->getFirstName(),
            'surname' => $this->getSurname(),
            'role' => $this->getRole(),
            'address' => $this->getAddress()->toArray(),
            'published' => $this->boolToStr($this->getPublished()),
            'private' => $this->boolToStr($this->getPrivate())
        );
    }
}