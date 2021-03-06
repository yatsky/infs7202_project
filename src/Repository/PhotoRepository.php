<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
//use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }
    public function loadSomePhotos(int $numPhotos): array
    {
//        $first100Photos = array();
//        $em = $this->getEntityManager();
//        $qb = $em->createQueryBuilder();
//        $qb->select('photo')
//            ->from('photo', 'p')
//            ->orderBy('photo.photoname')
//            ->setMaxResults($numPhotos)
//            ->getQuery();
        $qb = $this->createQueryBuilder("photo")
            ->add('select', '')
            ->setParameter("val", $numPhotos)
            ->orderBy("photo.id")
            ->getQuery();

        $photos = $qb->execute();
        return $photos;
    }
//    /**
//     * @return Photo[] Returns an array of Photo objects
//     */
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
    public function findOneBySomeField($value): ?Photo
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
