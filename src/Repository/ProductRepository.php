<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\ORM\Query;
use App\Data\SearchData;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{

  private $paginator;

    public function __construct(ManagerRegistry $registry , PaginatorInterface $paginator)
    {
        parent::__construct($registry, Product::class);
        $this->paginator = $paginator;
    }

    public function add(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }

       
    }
  public function findArchived(string $order = 'ASC') {

    $this->createQueryBuilder('p')
        ->where('p.deletedAt IS NOT NULL')
        ->orderBy('p.deletedAt',$order)
        ->getQuery()
        ->getResult();

  }

  public function findBySurface(object $product , int $surface , int $surfaceMax = 1000) {

    

        $entityManager = $this->getEntityManager();
  
        $query = $entityManager->createQuery(
            'SELECT :p
             FROM App\Entity\Product p
             WHERE p.surface BETWEEN :from AND :to
             '          
        )
        ->setParameter('p', $product)
        ->setParameter('from', $surface)
        ->setParameter('to', $surfaceMax);
      if  ($products = $query->getResult())
        {return $products;  }
        else{
            return null;
        }  

  }


  public function findSearch(SearchData $search):Query
  {
      $query = $this
      ->createQueryBuilder('p')
      ->join('p.ville' , 'v')
      ->addSelect('v');


      if(!empty($search->price))
      {
        $query = $query
        ->andWhere('p.price <= :max')
        ->andWhere('p.deletedAt IS NULL')
        ->setParameter('max', $search->price);
      }

      if(!empty($search->surface))
      {
        $query = $query
        ->andWhere('p.surface >= :min')
        ->andWhere('p.deletedAt IS NULL')
        ->setParameter('min', $search->surface);
      }

      if(!empty($search->piece))
      {
        $query = $query
        ->andWhere('p.piece >= :min')
        ->andWhere('p.deletedAt IS NULL')

        ->setParameter('min', $search->piece);
      }

      if(!empty($search->ville))
      {
        $query = $query
        ->andWhere('v.id IN (:ville)')
        ->andWhere('p.deletedAt IS NULL')
        ->setParameter('ville', $search->ville);
      }

      
      if(!empty($search->type))
      {
        $query = $query
        ->andWhere('p.type =:type')
        ->andWhere('p.deletedAt IS NULL')
        ->setParameter('type', $search->type);
      }

      return $query->getQuery();
      
  }
//   public function productCity($id) {


//     $entityManager = $this->getEntityManager();

//     $query = $entityManager->createQuery(
//         'SELECT v , p 
//          FROM App\Entity\Product p
//          INNER JOIN p.ville v
//          WHERE p.id = :id 
//          '          
//     )
//     ->setParameter('id', $id);
//     $ville = $query->getResult();
//     return $ville;    
// }
//    /**
//     * @return Product[] Returns an array of Product objects
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

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
