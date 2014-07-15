<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Dumper;

use Certificationy\Component\Certy\Model\Certification;

class PhpDumper extends FileDumper
{
    /**
     * @return string
     */
    protected function doDump(Certification $certification)
    {
        $dumped = clone $certification;

        foreach ($dumped->getCategories() as $category) {
            $category->setCertification(null);

            foreach ($category->getQuestions() as $question) {
                $question->setCategory(null);

                foreach ($question->getAnswers() as $answer) {
                    $answer->setQuestion(null);
                }
            }
        }

        $this->dumpFile($this->getFilePath($this->getFileName()), '<?php return '. var_export($dumped, true) .'; ?>');
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return '.php';
    }
}
