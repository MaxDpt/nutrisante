<?php

namespace App\Repository;

use App\Entity\Services;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Services>
 *
 * @method Services|null find($id, $lockMode = null, $lockVersion = null)
 * @method Services|null findOneBy(array $criteria, array $orderBy = null)
 * @method Services[]    findAll()
 * @method Services[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServicesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Services::class);
    }

    /**
     * @return Services[] Returns an array of services objects
     */
    public function findAllPaginatedServices($servicesPage, $servicesLimit)
    {
        $query = $this->createQueryBuilder('s');
            $query->orderBy('s.id', 'DESC')
            ->setFirstResult(($servicesPage * $servicesLimit) - $servicesLimit)
            ->setMaxResults($servicesLimit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * @return Count Returns total number of services
     */
    public function getTotalServices()
    {
        $query = $this->createQueryBuilder('s')
            ->select('COUNT(s)');
        
        return $query->getQuery()->getSingleScalarResult();
    }
}

