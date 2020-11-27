<?php

namespace App\Repository\NewsRepository;

use App\Entity\NewsEntity\Post;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    /**
     * @var PaginatorInterface $paginator|null
     */
    private PaginatorInterface $paginator;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em,PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
        $this->paginator=$paginator;
        $this->em=$em;

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

    /**
     * ceci retourne une pagination
     * @return PaginationInterface
     */
    public function searchPost(array $data=[]):PaginationInterface{
        $query=$this->findVisibleQuery()
                    ->getQuery();
        return $this->paginator->paginate($query,$data['page'],$data['number']);

    }

     /**
     * ceci retourne une pagination
     * @return PaginationInterface
     */
    public function searchPostByCategory(array $data=[]):PaginationInterface{
         $query=$this->em->createQuery(
                            'SELECT p
                                FROM App\Entity\NewsEntity\Post p
                                WHERE p.type > :val
                                
                                ORDER BY p.id ASC'
                            )
                            ->setParameter('val',$data['name'])
                            ->getResult();
        return $this->paginator->paginate($query,$data['page'],$data['number']);
    }
    private function findVisibleQuery()
    {

        return $this->createQueryBuilder('p')
              ->where('p.posted=true')
              ->select('cat','p')
              ->select('com','p')
              ->join('p.categories','cat')
              ->join('p.comments','com');
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
