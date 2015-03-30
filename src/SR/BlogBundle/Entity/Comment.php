<?php

namespace SR\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="SR\BlogBundle\Entity\CommentRepository")
 */
class Comment
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
    * @ORM\ManyToOne(targetEntity="SR\BlogBundle\Entity\Event")
    * 
    */
    private $event;

  /**
   * @ORM\ManyToOne(targetEntity="SR\BlogBundle\Entity\News")
   * 
   */
    private $news;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
    * @ORM\ManyToOne(targetEntity="SR\UserBundle\Entity\User")
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $postDate;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->postDate =  new \DateTime();
    }
    


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
     * Set content
     *
     * @param string $content
     * @return Comment
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
     * @return Comment
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
     * Set event
     *
     * @param \SR\BlogBundle\Entity\Event $event
     * @return Comment
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
     * Set news
     *
     * @param \SR\BlogBundle\Entity\News $news
     * @return Comment
     */
    public function setNews(\SR\BlogBundle\Entity\News $news)
    {
        $this->news = $news;

        return $this;
    }

    /**
     * Get news
     *
     * @return \SR\BlogBundle\Entity\News 
     */
    public function getNews()
    {
        return $this->news;
    }

    /**
     * Set user
     *
     * @param \SR\UserBundle\Entity\User $user
     * @return Comment
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
}
