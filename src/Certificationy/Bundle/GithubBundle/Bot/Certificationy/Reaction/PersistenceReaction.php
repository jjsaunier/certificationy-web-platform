<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\PersistenceAction;
use Gundam\Component\Bot\LoggerTrait;
use Gundam\Component\Bot\Reaction\LoggableReactionInterface;
use Certificationy\Bundle\GithubBundle\Document\InspectionReport;
use Doctrine\ODM\MongoDB\DocumentManager;

class PersistenceReaction implements LoggableReactionInterface
{
    use CheckReactionTrait, LoggerTrait;
    /**
     * @var DocumentManager
     */
    protected $documentManager;

    /**
     * @var string
     */
    protected $currentTaskHash;

    /**
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;
    }

    /**
     * @param PersistenceAction $action
     */
    public function perform(PersistenceAction $action)
    {
        $content = $action->getData()['content'];

        if ($action->getStatus() === PersistenceAction::TASK_START) {
            $sender = [
                'login' => $content['sender']['login'],
                'avatar_url' => $content['sender']['avatar_url'],
                'url' => $content['sender']['html_url']
            ];

            $data = [
                'html_url' => $content['pull_request']['html_url'],
                'diff_url' => $content['pull_request']['diff_url'],
                'patch_url' => $content['pull_request']['patch_url'],
                'title' => $content['pull_request']['title'],
                'label' => $content['pull_request']['head']['label']
            ];

            $inspection = new InspectionReport();
            $inspection->setSender($sender);
            $inspection->setChecksum($content['pull_request']['head']['sha']);
            $inspection->setErrors($action->getErrors());
            $inspection->setData($data);
            $inspection->setStatus(PersistenceAction::TASK_START);

            $this->documentManager->persist($inspection);
            $this->documentManager->flush();

            $this->currentTaskHash = $inspection->getId();
        }

        if ($action->getStatus() === PersistenceAction::TASK_END) {

            if (null === $this->currentTaskHash) {

                if (null !== $this->logger) {
                    $this->logger->warning('Unable to retrieve current hash of task to update it');
                }

                return;
            }

            $inspectionRepository = $this->documentManager->getRepository('CertificationyGithubBundle:InspectionReport');

            $inspection = $inspectionRepository->find($this->currentTaskHash);

            if (null !== $this->logger) {
                $this->logger->debug(sprintf(
                   'Update task %s to %s',
                    $this->currentTaskHash,
                    $action->getStatus()
                ));
            }

            if (null !== $event = $action->getStopwatchEvent()) {
                $inspection->setDuration($event->getDuration() / 1000);
            }

            $inspection->setErrors($action->getErrors());
            $inspection->setStatus(PersistenceAction::TASK_END);

            $this->documentManager->persist($inspection);
            $this->documentManager->flush();
        }
    }
}
