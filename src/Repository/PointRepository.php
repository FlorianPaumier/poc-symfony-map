<?php

namespace App\Repository;

use App\Entity\Point;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Point>
 */
class PointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Point::class);
    }

    public function paginate()
    {
        $name = $this->getClassMetadata()->getTableName();

        $sql = "
        SELECT ST_AsGeoJSON(geometry) as geometry
          FROM $name
    ";

        $stmt = $this->getEntityManager()->getConnection()->prepare($sql);
        $result = $stmt->executeQuery();
        return $result->fetchAllAssociative();

    }
}
