<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\EventListener;

use Certificationy\Component\Certy\Events\CustomContextEvent;
use Certificationy\Component\Certy\Model\Metrics;

class ContextListener
{
    /**
     * @param CustomContextEvent $event
     */
    public function removeQuestions(CustomContextEvent $event)
    {
        $certification = $event->getCertification();
        $context = $certification->getContext();
        $metrics = $certification->getMetrics();

        if (true !== $context->getAllowCustomNumberOfQuestions()) {
            return;
        }

        foreach ($certification->getCategories() as $category) {

            if ($context->getNumberOfQuestions() >= $questionCount = count($category->getQuestions())) {
                continue;
            }

            $questions = $category->getQuestions()->toArray();
            shuffle($questions);
            $questionToRemove = (array) array_rand($questions, $questionCount - $context->getNumberOfQuestions());

            $metrics->decrement(Metrics::QUESTION, count($questionToRemove));

            foreach ($questionToRemove as $index) {
                $question = $category->getQuestions()->get($index);
                $metrics->decrement(Metrics::ANSWER, count($question->getAnswers()));
                $category->getQuestions()->removeElement($question);
            }
        }

        $event->setCertification($certification);
    }

    /**
     * @param CustomContextEvent $event
     */
    public function removeCategories(CustomContextEvent $event)
    {
        $certification = $event->getCertification();
        $context = $certification->getContext();
        $metrics = $certification->getMetrics();
        $excludedCategories = $context->getExcludeCategories();

        if (empty($excludedCategories) || true !== $context->getAllowExcludeCategories()) {
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
