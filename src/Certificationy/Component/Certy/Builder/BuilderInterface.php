<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Builder;

use Certificationy\Component\Certy\Collector\CollectorInterface;
use Certificationy\Component\Certy\Context\CertificationContextInterface;
use Certificationy\Component\Certy\Model\Certification;

interface BuilderInterface
{
    /**
     * @param CollectorInterface $collector
     * @return void
     */
    public function __construct(CollectorInterface $collector = null);

    /**
     * @return Certification
     */
    public static function createCertification();

    /**
     * @param BuilderPassInterface $builderPass
     *
     * @return Builder
     */
    public function addBuilderPass(BuilderPassInterface $builderPass);

    /**
     * @param CertificationContextInterface $context
     *
     * @return Certification
     */
    public function build(CertificationContextInterface $context);
}
