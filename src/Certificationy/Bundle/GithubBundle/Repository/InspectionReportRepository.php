<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Repository;

use Doctrine\ODM\MongoDB\DocumentRepository;

class InspectionReportRepository extends DocumentRepository
{
    /**
     * @param $limit
     *
     * @return mixed
     */
    public function getLastInspection($limit)
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->limit($limit)
            ->sort('createdAt', 'ASC')
        ;

        return $qb->getQuery()->execute();
    }
}
