<?php

namespace App\Repository;

use App\Entity\Contact;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Contact>
 *
 * @method Contact|null find($id, $lockMode = null, $lockVersion = null)
 * @method Contact|null findOneBy(array $criteria, array $orderBy = null)
 * @method Contact[]    findAll()
 * @method Contact[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ContactRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Contact::class);
    }

    /**
     * @return Contacts[] Returns an array of contacts objects
     */
    public function findAllPaginatedMessages($messagesPage, $messagesLimit)
    {
        $query = $this->createQueryBuilder('c');
            $query->orderBy('c.id', 'DESC')
            ->setFirstResult(($messagesPage * $messagesLimit) - $messagesLimit)
            ->setMaxResults($messagesLimit)
        ;
        return $query->getQuery()->getResult();
    }

    /**
     * @return Count Returns total number of contacts 
     */
    public function getTotalMessages()
    {
        $query = $this->createQueryBuilder('u')
            ->select('COUNT(u)');
        
        return $query->getQuery()->getSingleScalarResult();
    }
}

