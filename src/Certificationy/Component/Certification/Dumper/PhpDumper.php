<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Dumper;

class PhpDumper extends FileDumper
{
    /**
     * @return string
     */
    protected function doDump()
    {
        foreach($this->certification->getCategories() as $category){
            $category->setCertification(null);

            foreach($category->getQuestions() as $question){
                $question->setCategory(null);

                foreach($question->getAnswers() as $answer){
                    $answer->setQuestion(null);
                }
            }
        }

        return '<?php return '. var_export($this->certification, true) .'; ?>';
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return '.php';
    }
}
