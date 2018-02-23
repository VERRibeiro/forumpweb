<?php

namespace App\Repositories;

use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class UserRepository
{
    use PaginatesFromParams;

    /**
     * @var string
     */
    private $class = User::class;

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
        return new User();
    }
 
    public function save( User $user )
    {
        $this->em->persist($user);
        $this->em->flush();
    }
 
    public function remove( User $user )
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function userByUsername( string $username )
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'username' => $username
        ]);
    }

    public function userByEmail( string $email )
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'email' => $email
        ]);
    }

    /**
     * @return User[]|LengthAwarePaginator
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