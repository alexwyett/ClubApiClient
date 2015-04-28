<?php

/**
 * Club object.
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
 * Club object.
 *
 * @category  Core
 * @package   ClubApiClient
 * @author    Alex Wyett <alex@wyett.co.uk>
 * @copyright 2015 Alex Wyett
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link      http://www.wyett.co.uk
 * 
 * @method string getName() Return the name
 * @method Club   setName() Set the name
 * 
 * @method string getDescription()             Return the desc
 * @method Club   setDescription(string $desc) Set the desc
 * 
 * @method collection\ClubVenue   getClubVenues() Get the club venues
 * @method collection\ClubLink    getLinks()      Get the club links
 * @method collection\ClubTag     getTags()       Get the club tags
 * @method collection\ClubContact getContacts()   Get the club contacts
 */
class Club extends PublishedEntity
{
    /**
     * Name
     * 
     * @var string
     */
    protected $name = '';
    
    /**
     * Description
     * 
     * @var string
     */
    protected $description = '';
    
    /**
     * Club venue collection
     * 
     * @var \aw\clubapiclient\collection\ClubVenue
     */
    protected $clubVenues;
    
    /**
     * Club links collection
     * 
     * @var \aw\clubapiclient\collection\ClubLink
     */
    protected $links;
    
    /**
     * Club tags collection
     * 
     * @var \aw\clubapiclient\collection\ClubTag
     */
    protected $tags;
    
    /**
     * Club contacts collection
     * 
     * @var \aw\clubapiclient\collection\ClubContact
     */
    protected $contacts;

    // ------------------ Static Functions --------------------- //
    
    /**
     * Fetch and build a club object from the api
     * 
     * @param integer $id Club id
     * 
     * @return Club
     */
    public static function get($id)
    {
        return self::_get('club/' . $id);
    }

    // ------------------ Public Functions --------------------- //
    
    /**
     * Constructor
     * 
     * @return void
     */
    public function __construct()
    {
        $this->clubVenues = new collection\ClubVenue();
        $this->clubVenues->setElementParent($this);
        
        $this->links = new collection\ClubLink();
        $this->links->setElementParent($this);
        
        $this->tags = new collection\ClubTag();
        $this->tags->setElementParent($this);
        
        $this->contacts = new collection\ClubContact();
        $this->contacts->setElementParent($this);
    }
    
    /**
     * Set the club venues
     * 
     * @param array $clubVenues Club venues array
     * 
     * @return Club
     */
    public function setClubVenues(array $clubVenues)
    {
        foreach ($clubVenues as $clubVenue) {
            $cv = ClubVenue::factory($clubVenue);
            $this->addClubVenue($cv);
        }
        
        return $this;
    }
    
    /**
     * Add a club venue to the collection
     * 
     * @param \aw\clubapiclient\ClubVenue $clubVenue Club venue
     * 
     * @return \aw\clubapiclient\Club
     */
    public function addClubVenue(ClubVenue &$clubVenue)
    {
        $this->clubVenues->addElement($clubVenue);
        
        return $this;
    }
    
    /**
     * Set the club links
     * 
     * @param array $links Club links array
     * 
     * @return Club
     */
    public function setLinks(array $links)
    {
        foreach ($links as $_link) {
            $link = Link::factory($_link);
            $this->addLink($link);
        }
        
        return $this;
    }
    
    /**
     * Add a link to the club
     * 
     * @param \aw\clubapiclient\Link $link Link
     * 
     * @return \aw\clubapiclient\Club
     */
    public function addLink(Link &$link)
    {
        $this->links->addElement($link);
        
        return $this;
    }
    
    /**
     * Set the club tags
     * 
     * @param array $tags Tags array
     * 
     * @return Club
     */
    public function setTags(array $tags)
    {
        foreach ($tags as $_tag) {
            $tag = Tag::factory($_tag);
            $this->addTag($tag);
        }
        
        return $this;
    }
    
    /**
     * Add a tag to the club
     * 
     * @param \aw\clubapiclient\Tag $tag Tag
     * 
     * @return \aw\clubapiclient\Club
     */
    public function addTag(Tag &$tag)
    {
        $this->tags->addElement($tag);
        
        return $this;
    }
    
    /**
     * Set the club contacts
     * 
     * @param array $contacts Contacts array
     * 
     * @return Club
     */
    public function setContacts(array $contacts)
    {
        foreach ($contacts as $_contact) {
            $contact = Contact::factory($_contact);
            $this->addContact($contact);
        }
        
        return $this;
    }
    
    /**
     * Add a contact to the club
     * 
     * @param \aw\clubapiclient\Contact $contact Contact
     * 
     * @return \aw\clubapiclient\Club
     */
    public function addContact(Contact &$contact)
    {
        $this->contacts->addElement($contact);
        
        return $this;
    }
    
    /**
     * ToString magic method
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
            'name' => $this->getName()
        );
    }
}