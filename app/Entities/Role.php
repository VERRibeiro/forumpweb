<?php

namespace App\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RoleRepository")
 * @ORM\Table(name="role")
 */
class Role
{
    const ADMINISTRATOR = 1;
    const USER = 2;
    const RESEARCHER = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=15, nullable=false)
     */
    protected $role;

    /**
     * @ORM\OneToMany(targetEntity="User", mappedBy="role", cascade={"ALL"})
     * @var ArrayCollection|User[]
     */
    protected $users;

    public function __construct()
    {
        $this->users = new ArrayCollection;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRole() : string
    {
        return $this->role;
    }

    public function setRole( string $role )
    {
        $this->role = $role;
    }

    public function getUsers() : ArrayCollection
    {
        return $this->users;
    }

    public function addUser( User $user )
    {
        if(!$this->users->contains($user)) {
            $this->users->add($user);
        }
    }

    public function removeUser( User $user )
    {
        if($this->users->contains($user)) {
            $this->users->remove($user);
        }
    }

}