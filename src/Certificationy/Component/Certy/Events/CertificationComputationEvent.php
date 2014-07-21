<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Events;

use Certificationy\Component\Certy\Calculator\Delegator\DelegatableInterface;
use Certificationy\Component\Certy\Model\Certification;
use Symfony\Component\EventDispatcher\Event;

class CertificationComputationEvent extends Event implements DelegatableInterface
{
    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @param Certification $certification
     */
    public function __construct(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * @param \Certificationy\Component\Certy\Model\Certification $certification
     */
    public function setCertification(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * @return \Certificationy\Component\Certy\Model\Certification
     */
    public function getCertification()
    {
        return $this->certification;
    }
}
