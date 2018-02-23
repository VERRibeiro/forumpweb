<?php

namespace App\Entities;

use DateTime;
use Doctrine\ORM\Mapping AS ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\ReplyRepository")
 * @ORM\Table(name="reply")
 */
class Reply
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
     * @ORM\ManyToOne(targetEntity="Topic", inversedBy="replies")
     * @var Topic
     */
    protected $topic;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="replies")
     * @var User
     */
    protected $user;

    public function __construct( $title, $message, $topic = NULL )
    {
    	$this->dateCreated = new DateTime();
    	$this->dateModified = $this->dateCreated;

        $this->title = $title;
        $this->message = $message;
        $this->topic = $topic;
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setTitle( string $title )
    {
    	$this->title = $title;
    }

    public function getTitle()
    {
    	return $this->title;
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

    public function setTopic( Topic $topic )
    {
        $this->topic = $topic;
        $topic->addReply($this);
    }

    public function getTopic()
    {
        return $this->topic;
    }

    public function setUser( User $user )
    {
        $this->user = $user;
        $user->addReply($this);
    }

    public function getUser()
    {
        return $this->user;
    }

}