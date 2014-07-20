<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\EventListener;

use Certificationy\Component\Certy\Events\CustomContextEvent;

class ContextScoreListener
{
    /**
     * @param CustomContextEvent $event
     */
    public function updateScore(CustomContextEvent $event)
    {
        $certification = $event->getCertification();
        $context = $certification->getContext();
        $metrics = $certification->getMetrics();

        //Define number of question automatically
        if (null === $context->getNumberOfQuestions()) {
            $context->setNumberOfQuestions($metrics->getQuestionCount());
        }

        //Define required score dynamically
        if (null === $context->getRequiredScore()) {
            $context->setRequiredScore(floor($metrics->getQuestionCount() / 2));
        }
    }
}
