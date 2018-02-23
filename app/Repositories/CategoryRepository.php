<?php

namespace App\Repositories;

use App\Entities\Category;
use Doctrine\ORM\EntityManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use LaravelDoctrine\ORM\Pagination\PaginatesFromParams;

class CategoryRepository
{
    use PaginatesFromParams;

    /**
     * @var string
     */
    private $class = Category::class;

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
        return new Category();
    }
 
    public function save( Category $category )
    {
        $this->em->persist($category);
        $this->em->flush();
    }
 
    public function remove( Category $category )
    {
        $this->em->remove($category);
        $this->em->flush();
    }

    public function categoryBySlug( string $slug )
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'slug' => $slug
        ]);
    }

    /**
     * @return Category[]|LengthAwarePaginator
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
     * @return Category[]|LengthAwarePaginator
     */
    public function findByCategoryName( string $category, int $limit = 8, int $page = 1 ): LengthAwarePaginator
    {
        $query = $this->createQueryBuilder('s')
            ->where('s.category LIKE :category')
            ->orderBy('s.category', 'asc')
            ->setParameter('category', "%$category%")
            ->getQuery();
        return $this->paginate($query, $limit, $page);
    }
}