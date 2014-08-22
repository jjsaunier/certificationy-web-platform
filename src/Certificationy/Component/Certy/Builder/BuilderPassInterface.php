<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Builder;

use Certificationy\Component\Certy\Collector\CollectorInterface;
use Certificationy\Component\Certy\Context\CertificationContextInterface;

interface BuilderPassInterface
{
    /**
     * @param BuilderInterface              $builder
     * @param CertificationContextInterface $certificationContext
     */
    public function execute(BuilderInterface $builder, CertificationContextInterface $certificationContext);

    /**
     * @param  CollectorInterface $collector
     * @return void
     */
    public function setCollector(CollectorInterface $collector);
}
