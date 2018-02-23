<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\TopicRepository")
 * @ORM\Table(name="topic")
 */
class Topic
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     */
    protected $title;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $slug;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    protected $message;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateModified;

    /**
     * @ORM\OneToMany(targetEntity="Reply", mappedBy="topic", cascade={"persist"})
     * @var ArrayCollection|Reply[]
     */
    protected $replies;

    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="topics")
     * @var Category
     */
    protected $category;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="topics")
     * @var User
     */
    protected $user;

    public function __construct()
    {
    	$this->dateCreated = new DateTime();
    	$this->dateModified = $this->dateCreated;
    	$this->replies = new ArrayCollection;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setTitle( string $title )
    {
    	$this->title = $title;
    	$this->slug = time() . '-' . encodeToURL($title);
    }

    public function getTitle()
    {
    	return $this->title;
    }

    public function getSlug()
    {
    	return $this->slug;
    }

    public function setMessage( string $message )
    {
    	$this->message = $message;
    }

    public function getMessage()
    {
    	return $this->message;
    }

    public function getDateCreated() : DateTime
    {
    	return $this->dateCreated;
    }

    public function setDateModified( DateTime $date )
    {
        $this->dateModified = $date;
    }

    public function getDateModified() : DateTime
    {
    	return $this->dateModified;
    }

    public function addReply( Reply $reply )
    {
        if(!$this->replies->contains($reply)) {
            $this->replies->add($reply);
        }
    }

    public function removeReply( Reply $reply )
    {
    	if($this->replies->contains($reply)) {
            $this->replies->remove($reply);
        }
    }

    public function setCategory( Category $category )
    {
    	$this->category = $category;
        $category->addTopic($this);
    }

    public function getCategory()
    {
    	return $this->category;
    }

    public function setUser( User $user )
    {
        $this->user = $user;
        $user->addTopic($this);
    }

    public function getUser()
    {
        return $this->user;
    }
}