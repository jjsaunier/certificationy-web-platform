<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\EventListener;

use Certificationy\Bundle\TrainingBundle\Document\Report;
use Certificationy\Component\Certy\Events\CertificationComputationEvent;
use Certificationy\Component\Certy\Model\Certification;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Component\Security\Core\SecurityContextInterface;

class StoreCertificationReportListener
{
    /**
     * @var \Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $documentManager;

    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @param DocumentManager          $documentManager
     * @param SecurityContextInterface $securityContext
     */
    public function __construct(DocumentManager $documentManager, SecurityContextInterface $securityContext)
    {
        $this->documentManager = $documentManager;
        $this->securityContext = $securityContext;
    }

    /**
     * @param CertificationComputationEvent $event
     */
    public function store(CertificationComputationEvent $event)
    {
        $certification = $event->getCertification();

        $this->persist($certification);
    }

    /**
     * @param Certification $certification
     */
    public function persist(Certification $certification)
    {
        $context = $certification->getContext();
        $metrics = $certification->getMetrics();
        $result = $certification->getResult();

        $report = new Report();
        $report->setName($context->getName());
        $report->setLabel($context->getLabel());
        $report->setScore($result->getScore());
        $report->setLanguage($context->getLanguage());
        $report->setMetrics($metrics->getAllReportMetrics());
        $report->setUserId($this->securityContext->getToken()->getUser()->getId());
        $report->setLevel($context->getLevel());
        $report->setScoreRequired($context->getRequiredScore());
        $report->setExcludedCategories($context->getExcludeCategories());

        $this->documentManager->persist($report);
        $this->documentManager->flush();
    }
}
