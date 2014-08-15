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

            if(in_array($file->getFileName(), $action->getSkip('file'))){
                continue;
            }

            $data = $parser->parse(file_get_contents($file->getRealPath()));

            $context = [
                'file_name' => $file->getFileName(),
                'file_path' => $file->getPathName(),
                'discriminator' => 'category',
                'training' => $this->getCurrentTraining($file)
            ];

            if (!is_array($data)) {

                $action->addError(
                    'structure',
                    'Output must be type of array, given '.gettype($data),
                    $context
                );

                $action->addSkip('category', $file->getFileName());

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

                $action->addSkip('category', $data['category']);

                continue;
            }

            if(empty($data['category'])){
                $action->addError(
                    'structure',
                    'Cannot have empty label',
                    $context
                );
            }

            if (!isset($data['questions']) || empty($data['questions'])) {

                $action->addError(
                    'structure',
                    'Missing questions',
                    $context
                );

                $action->addSkip('category', $data['category']);

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

                if (empty($questionNode['question'])) {
                    $action->addError(
                        'structure',
                        'Cannot have empty label',
                        $context
                    );
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

                    if(empty($answerNode['value'])){
                        $action->addError(
                            'structure',
                            sprintf('Cannot have empty label, related question : "%s"', $questionNode['question']),
                            $context
                        );
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
                        'Must have at least one valid answer',
                        $context
                    );

                    continue 2;
                }
            }
        }
    }
}
