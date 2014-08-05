<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\PersistenceAction;
use Certificationy\Bundle\GithubBundle\Document\InspectionReport;
use Doctrine\ODM\MongoDB\DocumentManager;

class PersistenceReaction
{
    /**
     * @var DocumentManager
     */
    protected $documentManager;

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

        $sender = array(
            'login' => $content['sender']['login'],
            'avatar_url' => $content['sender']['avatar_url'],
            'url' => $content['sender']['html_url']
        );

        $data = array(
            'html_url' => $content['pull_request']['html_url'],
            'diff_url' => $content['pull_request']['diff_url'],
            'patch_url' => $content['pull_request']['patch_url'],
            'title' => $content['pull_request']['title'],
            'label' => $content['pull_request']['head']['label']
        );

        $inspection = new InspectionReport();
        $inspection->setSender($sender);
        $inspection->setErrors($action->getErrors());
        $inspection->setData($data);
        $inspection->setChecksum($content['pull_request']['head']['sha']);

        $this->documentManager->persist($inspection);
        $this->documentManager->flush();
    }
}
