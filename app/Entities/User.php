<?php

namespace App\Entities;

use Illuminate\Support\Facades\Hash;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\UserRepository")
 * @ORM\Table(name="user")
 */
class User implements Authenticatable
{

    use \LaravelDoctrine\ORM\Auth\Authenticatable;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", nullable=false, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="string", length=20, nullable=false)
     */
    protected $username;

    /**
     * @ORM\Column(type="string", length=60, nullable=false)
     */
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity="Role", inversedBy="users", cascade={"ALL"})
     * @var Role
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="user", cascade={"ALL"})
     */
    protected $topics;

    /**
     * @ORM\OneToMany(targetEntity="Reply", mappedBy="answer", cascade={"ALL"})
     */
    protected $replies;

    public function __construct()
    {
        $this->role = new Role();
        $this->topics = new ArrayCollection;
        $this->replies = new ArrayCollection;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName( string $name )
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setEmail( string $email )
    {
        $this->email = $email;
    }

    public function getEmail() : string
    {
        return $this->email;
    }

    public function setUsername( string $username )
    {
        $this->username = $username;
    }

    public function getUsername() : string
    {
        return $this->username;
    }

    public function setPassword( string $password )
    {
        $this->password = Hash::make($password);
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    public function setRole( Role $role )
    {
        $this->role = $role;
        $role->addUser($this);
    }

    public function getRole() : Role
    {
        return $this->role;
    }

    public function addTopic( Topic $topic )
    {
        if(!$this->topics->contains($topic)) {
            $this->topics->add($topic);
        }
    }

    public function removeTopic( Topic $topic )
    {
        if($this->topics->contains($topic)) {
            $this->topics->remove($topic);
        }
    }

    public function getTopics() : ArrayCollection
    {
        return $this->topics;
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

    public function getReplies() : ArrayCollection
    {
        return $this->replies;
    }

    /**
     * Authenticatable interface methods implementation
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->getId();
    }

    public function getAuthPassword()
    {
        return $this->getPassword();
    }

    public function setRememberToken( $value )
    {
        $this->remember_token = $value;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}