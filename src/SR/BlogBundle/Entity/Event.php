<?php

namespace SR\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Event
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SR\BlogBundle\Entity\Repository\EventRepository")
 */
class Event
{
   

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
    * @ORM\OneToOne(targetEntity="SR\BlogBundle\Entity\Image", cascade={"persist","remove"})
    */
    private $image;

     /**
     * @ORM\ManyToOne(targetEntity="SR\BlogBundle\Entity\EventCategory")
     * @ORM\JoinColumn(nullable=false)
     */
     private $eventCategory;


    /**
    * @ORM\OneToMany(targetEntity="SR\BlogBundle\Entity\Movie", mappedBy="event",cascade={"remove","persist"})
    */
     private $movies; // Notez le « s », un évenement est lié à plusieurs films


    /**
    * @ORM\ManyToMany(targetEntity="SR\BlogBundle\Entity\Tag")
    */
    private $tags;


    /**
    * @ORM\ManyToMany(targetEntity="SR\BlogBundle\Entity\News")
    */
    private $news;

    /**
    * @ORM\ManyToOne(targetEntity="SR\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=true)
    */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     * @ORM\JoinColumn(nullable=true)
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var boolean
     *
     * @ORM\Column(name="event_status", type="boolean")
     */
    private $eventStatus;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_start_date", type="datetime")
     */
    private $eventStartDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="event_end_date", type="datetime")
     * @ORM\JoinColumn(nullable=true)
     */
    private $eventEndDate;

    /**
     * @var string
     *
     * @ORM\Column(name="event_rate", type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $eventRate;

    /**
     * @var string
     *
     * @ORM\Column(name="event_guest", type="string", length=255, nullable=true)
     */
    private $eventGuest;

    /**
     * @var string
     *
     * @ORM\Column(name="event_location", type="string", length=255)
     */
    private $eventLocation;

    /**
    *@Gedmo\Slug(fields={"title"})
    *@ORM\Column(length=128, unique=true)
    */
    private $slug;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Event
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set postDate
     *
     * @param \DateTime $postDate
     * @return Event
     */
    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;

        return $this;
    }

    /**
     * Get postDate
     *
     * @return \DateTime 
     */
    public function getPostDate()
    {
        return $this->postDate;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Event
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set eventStatus
     *
     * @param boolean $eventStatus
     * @return Event
     */
    public function setEventStatus($eventStatus)
    {
        $this->eventStatus = $eventStatus;

        return $this;
    }

    /**
     * Get eventStatus
     *
     * @return boolean 
     */
    public function getEventStatus()
    {
        return $this->eventStatus;
    }

    


    /**
     * Set eventStartDate
     *
     * @param \DateTime $eventStartDate
     * @return Event
     */
    public function setEventStartDate($eventStartDate)
    {
        $this->eventStartDate = $eventStartDate;

        return $this;
    }

    /**
     * Get eventStartDate
     *
     * @return \DateTime 
     */
    public function getEventStartDate()
    {
        return $this->eventStartDate;
    }

    /**
     * Set eventEndDate
     *
     * @param \DateTime $eventEndDate
     * @return Event
     */
    public function setEventEndDate($eventEndDate)
    {
        $this->eventEndDate = $eventEndDate;

        return $this;
    }

    /**
     * Get eventEndDate
     *
     * @return \DateTime 
     */
    public function getEventEndDate()
    {
        return $this->eventEndDate;
    }

    /**
     * Set eventRate
     *
     * @param string $eventRate
     * @return Event
     */
    public function setEventRate($eventRate)
    {
        $this->eventRate = $eventRate;

        return $this;
    }

    /**
     * Get eventRate
     *
     * @return string 
     */
    public function getEventRate()
    {
        return $this->eventRate;
    }


    /**
     * Set eventGuest
     *
     * @param string $eventGuest
     * @return Event
     */
    public function setEventGuest($eventGuest)
    {
        $this->eventGuest = $eventGuest;

        return $this;
    }

    /**
     * Get eventGuest
     *
     * @return string 
     */
    public function getEventGuest()
    {
        return $this->eventGuest;
    }

    /**
     * Set eventLocation
     *
     * @param string $eventLocation
     * @return Event
     */
    public function setEventLocation($eventLocation)
    {
        $this->eventLocation = $eventLocation;

        return $this;
    }

    /**
     * Get eventLocation
     *
     * @return string 
     */
    public function getEventLocation()
    {
        return $this->eventLocation;
    }

    /**
     * Set image
     *
     * @param \SR\BlogBundle\Entity\Image $image
     * @return Event
     */
    public function setImage(\SR\BlogBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \SR\BlogBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
        $this->movies = new ArrayCollection();
    }

    /**
     * Add tags
     *
     * @param \SR\BlogBundle\Entity\Tag $tags
     * @return Event
     */
    public function addTag(\SR\BlogBundle\Entity\Tag $tags)
    {
        $this->tags[] = $tags;

        return $this;
    }

    /**
     * Remove tags
     *
     * @param \SR\BlogBundle\Entity\Tag $tags
     */
    public function removeTag(\SR\BlogBundle\Entity\Tag $tags)
    {
        $this->tags->removeElement($tags);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set user
     *
     * @param \SR\UserBundle\Entity\User $user
     * @return Event
     */
    public function setUser(\SR\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \SR\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add news
     *
     * @param \SR\BlogBundle\Entity\News $news
     * @return Event
     */
    public function addNews(\SR\BlogBundle\Entity\News $news)
    {
        $this->news[] = $news;

        return $this;
    }

    /**
     * Remove news
     *
     * @param \SR\BlogBundle\Entity\News $news
     */
    public function removeNews(\SR\BlogBundle\Entity\News $news)
    {
        $this->news->removeElement($news);
    }

    /**
     * Get news
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNews()
    {
        return $this->news;
    }



    public function getMovies()
    {
        return $this->movies;
    }


// j'ai enlevé le type ArrayCollection pour pouvoir faire une mise à jour d'un film dans un evenement.
//Ca marche mais je dois chercher pouquoi lors d'une mise àjour on a pas un ArrayCollection mais un Doctrine\ORM\PersistentCollection. Pour corriger finalement j'ai vu qu'il faut mettre Collection
    public function setMovies( Collection $movies)  
    {
    
        foreach ($movies as $movie){
        
             $movie->setEvent($this);

        }

        $this->movies = $movies;
    }

    /**
     * Set eventCategory
     *
     * @param \SR\BlogBundle\Entity\EventCategory $eventCategory
     * @return Event
     */
    public function setEventCategory(\SR\BlogBundle\Entity\EventCategory $eventCategory)
    {
        $this->eventCategory = $eventCategory;

        return $this;
    }

    /**
     * Get eventCategory
     *
     * @return \SR\BlogBundle\Entity\EventCategory 
     */
    public function getEventCategory()
    {
        return $this->eventCategory;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Event
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Add movies
     *
     * @param \SR\BlogBundle\Entity\Movie $movies
     * @return Event
     */
    public function addMovie(\SR\BlogBundle\Entity\Movie $movies)
    {
        $this->movies[] = $movies;

        return $this;
    }

    /**
     * Remove movies
     *
     * @param \SR\BlogBundle\Entity\Movie $movies
     */
    public function removeMovie(\SR\BlogBundle\Entity\Movie $movies)
    {
        $this->movies->removeElement($movies);
    }
}
