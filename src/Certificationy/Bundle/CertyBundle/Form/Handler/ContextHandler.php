<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\Form\Handler;

use Certificationy\Component\Certy\Events\CertificationEvents;
use Certificationy\Component\Certy\Events\CustomContextEvent;
use Certificationy\Component\Certy\Model\Certification;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ContextHandler extends Handler
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Certification $certification
     *
     * @return bool
     */
    public function process(Certification $certification)
    {
        $this->createForm($certification->getContext(), ['certification' => $certification]);

        return $this->handle('POST');
    }

    /**
     * @param Certification $data
     *
     * @return Certification
     */
    protected function onSuccess($data)
    {
        $event = new CustomContextEvent($this->form->getConfig()->getOption('certification'));
        $this->eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_CUSTOM_CONTEXT, $event);

        return $event->getCertification();
    }
}
