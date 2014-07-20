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
use Certificationy\Component\Certy\Model\Metrics;

class ContextCategoryListener
{
    /**
     * @param CustomContextEvent $event
     */
    public function exclude(CustomContextEvent $event)
    {
        $certification = $event->getCertification();
        $context = $certification->getContext();
        $metrics = $certification->getMetrics();
        $excludedCategories = $context->getExcludeCategories();

        if (empty($excludedCategories)) {
            return;
        }

        foreach ($certification->getCategories() as $category) {
            if (!in_array($category->getName(), $excludedCategories)) {
                continue;
            }

            $metrics->decrement(Metrics::CATEGORY);

            foreach ($category->getQuestions() as $question) {
                $metrics->decrement(Metrics::QUESTION);
                $metrics->decrement(Metrics::ANSWER, count($question->getAnswers()));
            }

            $certification->removeCategory($category);
        }

        $event->setCertification($certification);
    }
}
