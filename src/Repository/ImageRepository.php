<?php

namespace App\Repository;

use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Image>
 *
 * @method Image|null find($id, $lockMode = null, $lockVersion = null)
 * @method Image|null findOneBy(array $criteria, array $orderBy = null)
 * @method Image[]    findAll()
 * @method Image[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Image::class);
    }

    public function add(Image $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Image $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function firstImage(int $id) {


        $entityManager = $this->getEntityManager();
  
        $query = $entityManager->createQuery(
            'SELECT i , p 
             FROM App\Entity\Image i
             INNER JOIN i.product p
             WHERE p.id = :id 
             '          
        )
        ->setFirstResult(0)
        ->setMaxResults(2)
        ->setParameter('id', $id);
        $images = $query->getResult();
        return $images;    
    }
    public function secondImage($id) {


        $entityManager = $this->getEntityManager();
  
        $query = $entityManager->createQuery(
            'SELECT i , p 
             FROM App\Entity\Image i
             INNER JOIN i.product p
             WHERE p.id = :id 
             '          
        )
        ->setFirstResult(2)
        ->setMaxResults(3)
        ->setParameter('id', $id);
        $images = $query->getResult();
        return $images;    
    }
    public function deleteImage(int $id)
    {
        
        $entityManager = $this->getEntityManager();
  
        $query = $entityManager->createQuery(
            'DELETE i 
             FROM App\Entity\Image i
             WHERE i.id = :id 
             '          
        )
        ->setParameter('id', $id);   
    }
//    /**
//     * @return Image[] Returns an array of Image objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Image
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
