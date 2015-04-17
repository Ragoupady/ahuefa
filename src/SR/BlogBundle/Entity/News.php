<?php

namespace SR\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * News
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SR\BlogBundle\Entity\NewsRepository")
 */
class News
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
    * @ORM\OneToOne(targetEntity="SR\BlogBundle\Entity\Image", cascade={"persist"})
    */
    private $image;

    /**
    *@ORM\ManyToMany(targetEntity="SR\BlogBundle\Entity\NewsCategory",cascade={"remove"})
    *
    */
    private $newsCategories;

    /**
    * @ORM\ManyToMany(targetEntity="SR\BlogBundle\Entity\Tag")
    */
    private $tags;

    /**
    * @ORM\ManyToOne(targetEntity="SR\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="news_date", type="datetime")
     */
    private $newsDate;

    /**
     * @var boolean
     *
     * @ORM\Column(name="news_status", type="boolean")
     */
    private $newsStatus;


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
     * @return News
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
     * @return News
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
     * Set newsDate
     *
     * @param \DateTime $newsDate
     * @return News
     */
    public function setNewsDate($newsDate)
    {
        $this->newsDate = $newsDate;

        return $this;
    }

    /**
     * Get newsDate
     *
     * @return \DateTime 
     */
    public function getNewsDate()
    {
        return $this->newsDate;
    }

    /**
     * Set newsStatus
     *
     * @param boolean $newsStatus
     * @return News
     */
    public function setNewsStatus($newsStatus)
    {
        $this->newsStatus = $newsStatus;

        return $this;
    }

    /**
     * Get newsStatus
     *
     * @return boolean 
     */
    public function getNewsStatus()
    {
        return $this->newsStatus;
    }

    /**
     * Set image
     *
     * @param \SR\BlogBundle\Entity\Image $image
     * @return News
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
        $this->newsCategories = new \Doctrine\Common\Collections\ArrayCollection();
        $this->newsDate = new \DateTime();
    }

    /**
     * Add newsCategories
     *
     * @param \SR\BlogBundle\Entity\NewsCategory $newsCategories
     * @return News
     */
    public function addNewsCategory(\SR\BlogBundle\Entity\NewsCategory $newsCategories)
    {
        $this->newsCategories[] = $newsCategories;

        return $this;
    }

    /**
     * Remove newsCategories
     *
     * @param \SR\BlogBundle\Entity\NewsCategory $newsCategories
     */
    public function removeNewsCategory(\SR\BlogBundle\Entity\NewsCategory $newsCategories)
    {
        $this->newsCategories->removeElement($newsCategories);
    }

    /**
     * Get newsCategories
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNewsCategories()
    {
        return $this->newsCategories;
    }

    /**
     * Add tags
     *
     * @param \SR\BlogBundle\Entity\Tag $tags
     * @return News
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
     * @return News
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


    public function __toString()
{
    return $this->getTitle();
}
}
