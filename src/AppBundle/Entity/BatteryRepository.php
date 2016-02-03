<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityRepository;

class BatteryRepository extends EntityRepository
{
    public function getStatistics()
    {
        return $this->createQueryBuilder('b')
            ->select('SUM(b.count) as total, b.type')
            ->groupBy('b.type')
            ->getQuery()
            ->getResult();
    }

    public function deleteAll()
    {
        return $this->createQueryBuilder('b')
            ->delete()
            ->getQuery()
            ->getResult();
    }
}