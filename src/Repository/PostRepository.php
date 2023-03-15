<?php

namespace App\Repository;

use App\Entity\Post\Category;
use App\Entity\Post\Post;
use App\Entity\Post\Tags;
use App\Model\SearchData;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginatorInterface)
    {
        parent::__construct($registry, Post::class);
    }

    public function save(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Post $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Get published post
     *
     * @return array
     */
    public function findPublished(int $page, ?Category $category = null, ?Tags $tags= null ) :PaginationInterface
    {
        $data = $this->createQueryBuilder('p')
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->orderBy('p.createdAt','DESC');

            if(isset($category))
            {
                $data =$data
                      ->join('p.categories', 'c')
                      ->andWhere(':category IN (c)')
                      ->setParameter('category', $category);
            }

            if(isset($tags))
            {
                $data =$data
                     ->join('p.tags', 't')
                      ->andWhere(':tags IN (t)')
                      ->setParameter('tags', $tags);
            }


            $data ->getQuery()
                 ->getResult();

            $post = $this->paginatorInterface->paginate($data,$page,9);
        return $post;    
    
    }

    public function findBySearch(SearchData $searchData) :PaginationInterface
    {
        $data =$this->createQueryBuilder('p')
            ->where('p.state LIKE :state')
            ->setParameter('state','%STATE_PUBLISHED%')
            ->orderBy('p.createdAt','DESC');

       if(!empty($searchData->q)){

        $data =$data
           ->andWhere('p.title LiKE :q')
           ->setParameter('q',"%{$searchData->q}%");
       }  
       $data = $data
            ->getQuery()
            ->getResult();
       
            $posts = $this->paginatorInterface->paginate($data,$searchData->page,9 );
            return $posts;
    }

//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
