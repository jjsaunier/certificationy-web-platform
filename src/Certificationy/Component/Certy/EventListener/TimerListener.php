<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\EventListener;

use Certificationy\Component\Certy\Events\CertificationEvent;

class TimerListener
{
    /**
     * @param CertificationEvent $event
     */
    public function startTimer(CertificationEvent $event)
    {
        $certification = $event->getCertification();
        $certification->getMetrics()->getTimer()->start();
    }

    /**
     * @param CertificationEvent $event
     */
    public function stopTimer(CertificationEvent $event)
    {
        $certification = $event->getCertification();

        $certification->getMetrics()->getTimer()->stop();
    }
}
