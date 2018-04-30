<?php

namespace App\Repository;

use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    /**
     * Load and return all photos that have id <= numPhotos
     * @param int $numPhotos number of photos to be loaded.
     * @return array First numPhotos photos
     */
    public function loadSomePhotos(int $numPhotos): array
    {
//        $first100Photos = array();
        $qb = $this->createQueryBuilder("photo")
            ->andWhere("photo.id <= :val")
            ->setParameter("val", $numPhotos)
            ->orderBy("photo.id")
            ->getQuery();

        $photos = $qb->execute();
        $imgs = array();
        foreach ($photos as $photo) {
            array_push($imgs, $photo->getPhotoName());
        }
        return $imgs;
    }

    public function tryMe(): array
    {
        return array("a" => "photo1", "b" => "photo2");
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
