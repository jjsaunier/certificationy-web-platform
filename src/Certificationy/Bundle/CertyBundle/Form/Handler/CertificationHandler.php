<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Form\Handler;

use Certificationy\Component\Certy\Events\CertificationEvents;
use Certificationy\Component\Certy\Events\CertificationSubmissionEvent;
use Certificationy\Component\Certy\Model\Certification;
use Certificationy\Component\Certy\Model\ResultCertification;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CertificationHandler extends Handler
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
     */
    public function process(Certification $certification)
    {
        $resultCertification = new ResultCertification();
        $this->createForm($resultCertification, array('certification' => $certification));

        return $this->handle('POST');
    }

    /**
     * @param ResultCertification $data
     */
    public function onSuccess($data)
    {
        $certification = $this->form->getConfig()->getOption('certification');
        $certification->setResult($data);

        $this->eventDispatcher->dispatch(
            CertificationEvents::CERTIFICATION_SUBMISSION,
            $event = new CertificationSubmissionEvent($certification)
        );

        return $event->getCertification();
    }
}
