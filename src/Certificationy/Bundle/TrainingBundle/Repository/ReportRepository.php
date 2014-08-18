<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Repository;

use Certificationy\Bundle\UserBundle\Entity\User;
use Doctrine\ODM\MongoDB\DocumentRepository;

class ReportRepository extends DocumentRepository
{
    /**
     * @param User $user
     */
    public function getQueryBuilderReportsForUser(User $user)
    {
        $qb = $this->createQueryBuilder();

        $qb
            ->field('userId')
            ->equals($user->getId())
            ->sort('createdAt', 'desc')
        ;

        return $qb;
    }
}
