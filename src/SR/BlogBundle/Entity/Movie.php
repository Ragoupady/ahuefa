<?php

namespace SR\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Movie
{


  /**
   * @ORM\ManyToOne(targetEntity="SR\BlogBundle\Entity\Event", inversedBy="movies")
   * @ORM\JoinColumn(nullable=false)
   */
  private $event;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    public $title;


    /**
    * @ORM\OneToOne(targetEntity="SR\BlogBundle\Entity\Image",cascade={"persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $image;

        /**
     * @var \DateTime
     *
     * @ORM\Column(name="duration", type="time")
     * @ORM\JoinColumn(nullable=true)
     */
    private $duration;

     /**
     * @var string
     *
     * @ORM\Column(name="year", type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $year;

    /**
     * @var string
     *
     * @ORM\Column(name="movieContent", type="text")
     * @ORM\JoinColumn(nullable=true)
     */
    private $movieContent;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     * @ORM\JoinColumn(nullable=true)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="authoBio", type="text")
     * @ORM\JoinColumn(nullable=true)
     */
    private $authoBio;


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
     * @return Movie
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
     * Set event
     *
     * @param \SR\BlogBundle\Entity\Event $event
     * @return Movie
     */
    public function setEvent(\SR\BlogBundle\Entity\Event $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \SR\BlogBundle\Entity\Event 
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set duration
     *
     * @param \DateTime $duration
     * @return Movie
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return \DateTime 
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Set year
     *
     * @param string $year
     * @return Movie
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return string 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set movieContent
     *
     * @param string $movieContent
     * @return Movie
     */
    public function setMovieContent($movieContent)
    {
        $this->movieContent = $movieContent;

        return $this;
    }

    /**
     * Get movieContent
     *
     * @return string 
     */
    public function getMovieContent()
    {
        return $this->movieContent;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Movie
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set authoBio
     *
     * @param string $authoBio
     * @return Movie
     */
    public function setAuthoBio($authoBio)
    {
        $this->authoBio = $authoBio;

        return $this;
    }

    /**
     * Get authoBio
     *
     * @return string 
     */
    public function getAuthoBio()
    {
        return $this->authoBio;
    }

    /**
     * Set image
     *
     * @param \SR\BlogBundle\Entity\Image $image
     * @return Movie
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
}
