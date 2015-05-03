<?php

namespace Certificationy\Bundle\UserBundle\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    public function countMembers()
    {
        $qb = $this->getEntityManager()->createQueryBuilder();

        $qb->select('COUNT(usr.id) as members_count')->from($this->getEntityName(), 'usr');

        $query = $qb->getQuery();
        $query->useResultCache(true, 3600); //1d
        $query->useQueryCache(true);

        return $query->getSingleScalarResult();
    }
}