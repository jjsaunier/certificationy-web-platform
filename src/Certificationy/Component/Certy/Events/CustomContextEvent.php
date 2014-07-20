<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Events;

use Certificationy\Component\Certy\Model\Certification;
use Symfony\Component\EventDispatcher\Event;

class CustomContextEvent extends Event
{
    /**
     * @var Certification
     */
    protected $certification;

    /**
     * @param Certification $context
     */
    public function __construct(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * @param Certification $context
     */
    public function setCertification($certification)
    {
        $this->certification = $certification;
    }

    /**
     * @return Certification
     */
    public function getCertification()
    {
        return $this->certification;
    }
}
