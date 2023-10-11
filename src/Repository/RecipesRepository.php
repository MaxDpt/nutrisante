<?php

namespace App\Repository;

use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Recipes>
 *
 * @method Recipes|null find($id, $lockMode = null, $lockVersion = null)
 * @method Recipes|null findOneBy(array $criteria, array $orderBy = null)
 * @method Recipes[]    findAll()
 * @method Recipes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecipesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Recipes::class);
    }

/**
* @return Users[] Returns an array of Recipes objects
*/
public function findAllPaginatedRecipes($recipesPage, $recipesLimit)
{
   $query = $this->createQueryBuilder('r');
       $query->orderBy('r.id', 'DESC')
       ->setFirstResult(($recipesPage * $recipesLimit) - $recipesLimit)
       ->setMaxResults($recipesLimit)
   ;
   return $query->getQuery()->getResult();
}

/**
* @return Count Returns total number of Recipes
*/
public function getTotalRecipes()
{
   $query = $this->createQueryBuilder('r')
       ->select('COUNT(r)');
   
   return $query->getQuery()->getSingleScalarResult();
}
}
