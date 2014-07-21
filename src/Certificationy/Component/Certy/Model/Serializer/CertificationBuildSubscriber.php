<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Model\Serializer;

use JMS\Serializer\EventDispatcher\Event;
use JMS\Serializer\EventDispatcher\EventSubscriberInterface;
use JMS\Serializer\EventDispatcher\PreSerializeEvent;

class CertificationBuildSubscriber implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            array(
                'event' => 'serializer.post_deserialize',
                'method' => 'onPostDeserialize',
                'class' => 'Certificationy\Component\Certy\Model\Certification'
            ),
            array(
                'event' => 'serializer.pre_serialize',
                'method' => 'onPreSerialize',
                'class' => 'Certificationy\Component\Certy\Model\Certification'
            ),
        );
    }

    /**
     * @param Event $event
     */
    public function onPreSerialize(PreSerializeEvent $event)
    {
        foreach ($event->getObject()->getCategories() as $category) {
            $category->setCertification(null);

            foreach ($category->getQuestions() as $question) {
                $question->setCategory(null);

                foreach ($question->getAnswers() as $answer) {
                    $answer->setQuestion(null);
                }
            }
        }
    }

    /**
     * @param Event $event
     */
    public function onPostDeserialize(Event $event)
    {
        $context = $event->getContext();

        if ($context->getDepth() > 0) {
            return;
        }

        $certification = $event->getContext()->getVisitor()->getResult();

        foreach ($certification->getCategories() as $category) {
            $category->setCertification($certification);

            foreach ($category->getQuestions() as $question) {
                $question->setCategory($category);

                foreach ($question->getAnswers() as $answer) {
                    $answer->setQuestion($question);
                }
            }
        }
    }
}
