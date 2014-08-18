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
use Certificationy\Bundle\GithubBundle\Bot\Common\LoggerTrait;
use Certificationy\Bundle\GithubBundle\Bot\Common\Reaction\LoggableReactionInterface;
use Symfony\Component\Yaml\Parser;

class CheckUniquenessReaction implements LoggableReactionInterface
{
    use CheckReactionTrait, LoggerTrait;

    /**
     * @param CheckAction $action
     */
    public function perform(CheckAction $action)
    {
        $files = $this->getFiles($action->getBasePath());
        $parser = new Parser();

        $collector = [
            'category' => [],
            'question' => [],
            'answer' => []
        ];

        foreach ($files as $file) {

            if (in_array($file->getFileName(), $action->getSkip('file'))) {
                continue 1;
            }

            $data = $parser->parse(file_get_contents($file->getRealPath()));

            if (in_array($data['category'], $action->getSkip('category'))) {
                continue 1;
            }

            $trainingName = $this->getCurrentTraining($file);
            $identifier = implode('=', [$trainingName, $file->getFileName()]);

            $collector['category'][$identifier] = $data['category'];

            foreach ($data['questions'] as $questionNode) {

                if (in_array($questionNode['question'], $action->getSkip('question'))) {
                    continue 2;
                }

                $collector['question'][$identifier][] = $questionNode['question'];

                foreach ($questionNode['answers'] as $answerNode) {
                    if (in_array($answerNode['value'], $action->getSkip('answer'))) {
                        continue 3;
                    }

                    $collector['answer'][$identifier][$questionNode['question']][] = $answerNode['value'];
                }
            }
        }

        foreach ($collector as $type => $node) {
            if ($type === 'category') { //flatten
                foreach (array_count_values($collector[$type]) as $category => $count) {
                    if ($count > 1) {

                        $affected = array_keys($collector[$type], $category);

                        $errorFiles = [];

                        foreach ($affected as $value) {
                            list($training, $file) = explode('=', $value);
                            $errorFiles[] = $file;
                        }

                        $action->addError(
                            'integrity',
                            sprintf(
                                'Category "%s" was find several times',
                                $category
                            ),
                            [
                                'file_name' => $errorFiles,
                                'discriminator' => 'category',
                                'training' => $training
                            ]
                        );
                    }
                }
            }

            if ($type === 'question') { //nested
                foreach ($node as $context => $questionsNodes) {
                    list($training, $fileName) = explode('=', $context);

                    foreach (array_count_values($questionsNodes) as $question => $count) {

                        if ($count > 1) {
                            $action->addError(
                                'integrity',
                                sprintf(
                                    'Question "%s" was find several times',
                                    $question
                                ),
                                [
                                    'file_name' => $fileName,
                                    'discriminator' => 'question',
                                    'training' => $training
                                ]
                            );
                        }
                    }
                }
            }

            if ($type === 'answer') { //nested
                foreach ($node as $context => $answerNode) {
                    list($training, $fileName) = explode('=', $context);

                    foreach ($answerNode as $question => $answers) {

                        foreach (array_count_values($answers) as $answer => $count) {
                            if ($count > 1) {
                                $action->addError(
                                    'integrity',
                                    sprintf(
                                        'Answer "%s" was find several times for question "%s"',
                                        $answer,
                                        $question
                                    ),
                                    [
                                        'file_name' => $fileName,
                                        'discriminator' => 'answer',
                                        'training' => $training
                                    ]
                                );
                            }
                        }
                    }
                }
            }
        }
    }
}
