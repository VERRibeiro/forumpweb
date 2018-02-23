<?php

namespace App\Repositories;

use App\Entities\Role;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class RoleRepository
{
    use PaginatesFromParams;

    /**
     * @var string
     */
    private $class = Role::class;

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
        return new Role();
    }
 
    public function save( Role $role )
    {
        $this->em->persist($role);
        $this->em->flush();
    }
 
    public function remove( Role $role )
    {
        $this->em->remove($role);
        $this->em->flush();
    }

    /**
     * @return Role[]|LengthAwarePaginator
     */
    public function all( int $limit = 8, int $page = 1 ): LengthAwarePaginator
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

    /**
     * @return Role[]|LengthAwarePaginator
     */
    public function findByRoleName( string $role, int $limit = 8, int $page = 1 ): LengthAwarePaginator
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.role LIKE :role')
            ->orderBy('s.role', 'asc')
            ->setParameter('role', "%$role%")
            ->getQuery();
        return $this->paginate($query, $limit, $page);
    }
}