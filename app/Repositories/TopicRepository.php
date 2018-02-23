<?php

namespace App\Repositories;

use App\Entities\Topic;
use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class TopicRepository
{
    use PaginatesFromParams;

    /**
     * @var string
     */
    private $class = Topic::class;

    /**
     * @var EntityManager
     */
    private $em;
 
 
    public function __construct( EntityManager $em )
    {
        $this->em = $em;
    }

    public function new()
    {
        return new Topic();
    }
 
    public function save( Topic $topic )
    {
        $this->em->persist($topic);
        $this->em->flush();
    }
 
    public function remove( Topic $topic )
    {
        $this->em->remove($topic);
        $this->em->flush();
    }

    public function topicsByUser( User $user )
    {
        return $this->em->getRepository($this->class)->findBy([
            'user' => $user
        ]);
    }

    /**
     * @return Topic[]|LengthAwarePaginator
     */
    public function all( int $limit = 10, int $page = 1 ): LengthAwarePaginator
    {
        // paginateAll is already public, you may use it directly as well.
        return $this->paginateAll($limit, $page);
    }

    /**
     * Creates a new QueryBuilder instance that is prepopulated for this entity name.
     *
     * @param string $alias
     * @param string $indexBy The index for the from.
     *
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function createQueryBuilder( string $alias, string $indexBy = null ) : \Doctrine\ORM\QueryBuilder
    {
        $qb = new \Doctrine\ORM\QueryBuilder();
        return $qb->from($this->class, $alias);
    }
}