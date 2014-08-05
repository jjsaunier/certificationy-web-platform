<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Certificationy\Bundle\GithubBundle\Bot\Certificationy\Action\CheckAction;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class CheckStructureReaction
{
    use CheckReactionTrait;

    /**
     * @param CheckAction $action
     */
    public function perform(CheckAction $action)
    {
        $files = $this->getFiles($action->getBasePath());
        $parser = new Parser();

        foreach ($files as $file) {

            try {
                $data = $parser->parse(file_get_contents($file->getRealPath()));
            } catch (ParseException $e) {
                continue;
            }

            $context = array(
                'file_name' => $file->getFileName(),
                'file_path' => $file->getPathName(),
                'discriminator' => 'category'
            );

            if (!is_array($data)) {

                $action->addError(
                    'structure',
                    'Output must be type of array, given '.gettype($data),
                    $context
                );

                continue;
            }

            if (empty($data)) {

                $action->addError(
                    'structure',
                    'Resource file cannot be empty',
                    $context
                );

                continue;
            }

            //Structure without data can pass
            if (1 === count($data) && isset($data['category'])) {
                continue;
            }

            if (!isset($data['questions']) || empty($data['questions'])) {

                $action->addError(
                    'structure',
                    'Missing questions',
                    $context
                );

                continue;
            }

            foreach ($data['questions'] as $questionNode) {
                $context['discriminator'] = 'question';

                if (!isset($questionNode['question'])) {

                    $action->addError(
                        'structure',
                        'Required a question',
                        $context
                    );

                    continue 2;
                }

                if (!is_string($questionNode['question'])) {
                    $action->addError(
                        'structure',
                        'Should be a string',
                        $context
                    );

                    continue 2;
                }

                if (!isset($questionNode['answers']) || count($questionNode['answers']) <= 1) {

                    $action->addError(
                        'structure',
                        'Must contains at least 2 answers to be valid',
                        $context
                    );

                    continue 2;
                }

                $good = 0;

                foreach ($questionNode['answers'] as $answerNode) {
                    $context['discriminator'] = 'answer';

                    if (!isset($answerNode['value']) || !is_string($answerNode['value'])) {

                        $action->addError(
                            'structure',
                            'Missing or invalid [value] field',
                            $context
                        );

                        continue 3;
                    }

                    if (!isset($answerNode['correct']) || !is_bool($answerNode['correct'])) {

                        $action->addError(
                            'structure',
                            'Missing or invalid [correct] field',
                            $context
                        );

                        continue 3;
                    }

                    if (true === $answerNode['correct']) {
                        $good++;
                    }
                }

                if (0 === $good) {
                    $action->addError(
                        'structure',
                        'Must have at lease one valid answer',
                        $context
                    );

                    continue 2;
                }
            }
        }
    }
}
