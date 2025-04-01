<?php

namespace App\Repository;

use App\Entity\Books;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Books>
 */
class BooksRepository extends ServiceEntityRepository
{
    private PaginatorInterface $paginator;

    public function __construct(ManagerRegistry $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Books::class); // Appelle le constructeur parent avec ManagerRegistry
        $this->paginator = $paginator;
    }

    public function paginateBooks(int $page, int $limit)
    {
        return $this->paginator->paginate(
            $this->createQueryBuilder('b'), // Requête de base pour paginer les livres
            $page,
            $limit
        );
    }

    public function findWithComments()
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.comments', 'c')
            ->addSelect('c')
            ->getQuery()
            ->getResult();
    }

    //    public function findOneBySomeField($value): ?Books
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}