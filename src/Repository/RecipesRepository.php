<?php

namespace App\Repository;

use App\Entity\Recipes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Cast\Array_;

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
* @return Recipes[] Returns an array of Recipes objects
*/
public function findAllPaginatedRecipes($recipesPage, $recipesLimit, $diet = null, $allergen = null, $search = null )
{
    $query = $this->createQueryBuilder('r');
    if ($search !== null) {
        $query
        ->andWhere("r.name LIKE '%{$search}%' ");
    }
    if ($diet !== null) {
        for ($i = 0; $i <= count($diet) - 1; $i ++) {
            $query
            ->andWhere("r.diet LIKE '%{$diet[$i]}%' ");
    }}
    if ($allergen !== null) {
        for ($i = 0; $i <= count($allergen) - 1; $i ++) {
            $query
            ->andWhere("r.allergen NOT LIKE '%{$allergen[$i]}%' ");
    }}
    $query
        ->orderBy('r.id', 'DESC')
        ->setFirstResult(($recipesPage * $recipesLimit) - $recipesLimit)
        ->setMaxResults($recipesLimit);

    return $query->getQuery()->getResult();
}

/**
* @return Count Returns total number of Recipes
*/
public function getTotalRecipes($diet = null, $allergen = null, $search = null)
{
   $query = $this->createQueryBuilder('r');
   if ($search !== null) {
    $query
    ->andWhere("r.name LIKE '%{$search}%' ");
    }
   if ($diet !== null) {
        for ($i = 0; $i <= count($diet) - 1; $i ++) {
            $query
            ->andWhere("r.diet LIKE '%{$diet[$i]}%' ");
    }}
    if ($allergen !== null) {
        for ($i = 0; $i <= count($allergen) - 1; $i ++) {
            $query
            ->andWhere("r.allergen NOT LIKE '%{$allergen[$i]}%' ");
    }}
    $query ->select('COUNT(r)');
   
   return $query->getQuery()->getSingleScalarResult();
}
}
