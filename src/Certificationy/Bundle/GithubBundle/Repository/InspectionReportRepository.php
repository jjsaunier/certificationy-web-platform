<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
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
            ->sort('createdAt', 'DESC')
        ;

        return $qb->getQuery()->execute();
    }
}
