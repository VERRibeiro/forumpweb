<?php

namespace App\Entities;

use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repositories\CategoryRepository")
 * @ORM\Table(name="category")
 */
class Category
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", unique=true, nullable=false)
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $category;

    /**
     * @ORM\Column(type="string", unique=true, nullable=false)
     */
    protected $slug;

    /**
     * @ORM\OneToMany(targetEntity="Topic", mappedBy="category", cascade={"persist"})
     * @var ArrayCollection|Topic[]
     */
    protected $topics;

    public function __construct( $category = NULL )
    {
    	if( ! is_null($category) )
            $this->setCategory($category);
    }

    public function getId()
    {
    	return $this->id;
    }

    public function setCategory( string $category )
    {
    	$this->category = $category;
        $this->slug = encodeToURL($category);
    }

    public function getCategory()
    {
    	return $this->category;
    }

    public function getSlug()
    {
    	return $this->slug;
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
}