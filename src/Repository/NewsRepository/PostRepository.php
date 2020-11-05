<?php

namespace App\Repository\NewsRepository;

use App\Entity\NewsEntity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * Ceci retourne les dernieres articles
     */
    public function findLatest(){
        return $this->findVisibleQuery()
                     ->setMaxResults(3)
                     ->getQuery()
                     ->getResult();
    }
     public function findByGlobal(){
        return $this->findVisibleQuery()
                    ->andWhere('p.type =:val')
                    ->setParameter('val','global')
                     ->setMaxResults(2)
                     ->getQuery()
                     ->getResult();
    }
    
    private function findVisibleQuery()
    {

        return $this->createQueryBuilder('p')
              ->where('p.posted=true');
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
