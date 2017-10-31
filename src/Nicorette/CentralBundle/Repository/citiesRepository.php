<?php

namespace Nicorette\CentralBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * citiesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class citiesRepository extends EntityRepository {

    public function findCitiesByZipCode($zip) {
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->like('c.zip', $qb->expr()->literal($zip . '%')));

        $result = $qb->getQuery()->getResult();

        return $result;
    }
    
    public function findZipCodesByCity($city) {
        $qb = $this->createQueryBuilder('c');
        $qb->where($qb->expr()->like('c.name', $qb->expr()->literal($city . '%')));

        $result = $qb->getQuery()->getResult();

        return $result;
    }

}