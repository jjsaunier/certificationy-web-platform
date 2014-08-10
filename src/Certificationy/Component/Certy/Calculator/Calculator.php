<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Calculator;

use Certificationy\Component\Certy\Events\CertificationComputeEvent;
use Certificationy\Component\Certy\Events\CertificationEvents;
use Certificationy\Component\Certy\Model\Answer;
use Certificationy\Component\Certy\Model\Category;
use Certificationy\Component\Certy\Model\Certification;
use Certificationy\Component\Certy\Model\Question;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Calculator implements CalculatorInterface
{
    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param Certification $certification
     *
     * @return Certification
     */
    public function compute(Certification $certification)
    {
        $result = $certification->getResult()->getResults();
        $score = 0;

        foreach ($certification->getCategories() as $category) {
            foreach ($category->getQuestions() as $question) {
                foreach ($question->getAnswers() as $answer) {

                    if (in_array(self::getHash($category, $question, $answer), $result)) {
                        $answer->setAsAnswered();
                    }
                }

                if ($question->isValid()) {

                    $validEvent = new CertificationComputeEvent($question);
                    $this->eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_VALID_QUESTION, $validEvent);

                    if(true === $validEvent->isSkipped()){

                        if(null !== $this->logger){
                            $this->logger->info(sprintf(
                                'Question %s skipped',
                                $question->getLabel()
                            ));
                        }

                        continue;
                    }

                    $score++;
                } else {
                    $invalidEvent = new CertificationComputeEvent($question);
                    $this->eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_INVALID_QUESTION, $invalidEvent);
                }
            }

            $certification->getMetrics()->addReportMetrics($category);
        }

        $certification->getResult()->setScore($score);

        return $certification;
    }

    /**
     * @param Category $category
     * @param Question $question
     * @param Answer   $answer
     *
     * @return string
     */
    public static function getHash(Category $category, Question $question, Answer $answer)
    {
        return md5(
            $category->getName().
            $question->getName().
            $answer->getName()
        );
    }
}
