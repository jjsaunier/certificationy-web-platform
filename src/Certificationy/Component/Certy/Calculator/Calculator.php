<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Calculator;

use Certificationy\Component\Certy\Model\Answer;
use Certificationy\Component\Certy\Model\Category;
use Certificationy\Component\Certy\Model\Certification;
use Certificationy\Component\Certy\Model\Question;

class Calculator implements CalculatorInterface
{
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

                    /**
                     * Send event OnValidQuestion
                     */

                    $score++;
                } else {
                    /**
                     * Send event OnInvalidQuestion
                     */
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
