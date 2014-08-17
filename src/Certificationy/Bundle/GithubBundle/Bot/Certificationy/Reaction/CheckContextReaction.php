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
use Certificationy\Bundle\GithubBundle\Bot\Common\Reaction\LoggableReactionInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class CheckContextReaction implements LoggableReactionInterface
{
    /**
     * @var \Symfony\Component\Validator\Validator\ValidatorInterface
     */
    protected $validator;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param LoggerInterface $logger
     *
     * @return mixed
     */
    public function setLogger(LoggerInterface $logger = null)
    {
        $this->logger = $logger;
    }

    /**
     * @param CheckAction $action
     *
     * @return Finder
     */
    public function perform(CheckAction $action)
    {
        $finder = new Finder();
        $files = $finder->in($action->getBasePath().'/*')->name('context.yml');
        $parser = new Parser();
        $collector = [];

        foreach ($files as $context) {

            $errorContext = [
                'file_name' => $context->getFileName(),
                'file_path' => $context->getPathName(),
                'discriminator' => 'context',
                'training' => $this->getCurrentTraining($context)
            ];

            try {
                $contextData = $parser->parse(file_get_contents($context->getRealPath()));
            } catch (ParseException $e) {
                $action->addError('parser', $e->getMessage(), $errorContext);

                $action->addSkip('file', $context->getFileName());

                continue;
            }

            $mandatory = ['name', 'icons', 'label', 'availableLanguages', 'customize', 'threshold', 'defaults'];

            foreach ($mandatory as $key) {
                if (!isset($contextData[$key])) {
                    $action->addError(
                        'structure',
                        sprintf('Missing required key "%s"', $key),
                        $errorContext
                    );
                }
            }

            if (isset($contextData['name']) && isset($contextData['label'])) {
                $collector[$this->getCurrentTraining($context).'=name'][] = $contextData['name'];
                $collector[$this->getCurrentTraining($context).'=label'][] = $contextData['label'];
            }

            foreach ($contextData as $key => $value) {

                if (in_array($key, ['name', 'label'])) {
                    if (!is_string($key) || empty($key)) {
                        $action->addError(
                            'structure',
                            sprintf('Key "%s" must be type of "string" and not empty', $key),
                            $errorContext
                        );
                    }

                    continue;
                }

                if ('availableLanguages' === $key) {
                    if (!is_array($value)) {
                        $action->addError(
                            'structure',
                            sprintf('Key "%s" must be type of array with at least one element', $key),
                            $errorContext
                        );

                        continue;
                    }

                    if (0 === count($value)) {
                        $action->addError(
                            'structure',
                            sprintf('Key "%s" must contain at least one element', $key),
                            $errorContext
                        );

                        continue;
                    }

                    foreach ($value as $vlKey => $vlValue) {
                        if (!is_string($vlValue)) {
                            $action->addError(
                                'structure',
                                sprintf('Child %s of key "%s" must be a string, given "%s"', $vlKey, $key, gettype($vlValue)),
                                $errorContext
                            );

                            continue 2;
                        }
                    }
                }

                if ('availableLevels' === $key && null !== $value) {
                    foreach ($value as $vlKey => $vlValue) {
                        if (!is_string($vlValue)) {
                            $action->addError(
                                'structure',
                                $errorContext
                            );

                            continue 2;
                        }
                    }
                }

                if ('customize' === $key) {
                    $requiredKeys = [ 'exclude_categories', 'number_of_questions' ];

                    foreach ($requiredKeys as $vlValue) {
                        if (!array_key_exists($vlValue, $value)) {
                            $action->addError(
                                'structure',
                                sprintf('Mandatory key "%s" missing for parameter "%s"', $vlValue, $key),
                                $errorContext
                            );

                            continue 2;
                        }

                        if (!is_bool($value[$vlValue])) {
                            $action->addError(
                                'structure',
                                sprintf('Child "%s" of "%s" must be type of "bool", given "%s"', $vlValue, $key, gettype($value)),
                                $errorContext
                            );

                            continue 2;
                        }
                    }
                }

                if ('threshold' === $key && null !== $value) {

                    if (!is_array($value) || empty($value)) {
                        $action->addError(
                            'structure',
                            sprintf('Key "%s" must be type of array with at least one element, given "%s"', $key, gettype($value)),
                            $errorContext
                        );

                        continue;
                    }

                    foreach ($value as $vlKey => $vlValue) {
                        if (!is_string($vlKey) || !is_int($vlValue)) {
                            $action->addError(
                                'structure',
                                sprintf('Threshold must be like "(string) level_id => (int) score_trigger, given %s => %s"', $vlKey, $vlValue),
                                $errorContext
                            );
                        }
                    }
                }

                if ('defaults' === $key) {
                    if (!is_array($value)) {
                        $action->addError(
                            'structure',
                            sprintf('Key "%s" must be type of array, given "%s"', $key, gettype($value)),
                            $errorContext
                        );

                        continue;
                    }

                    $childrenRequired = [ 'language', 'questions_peer_category' ];

                    foreach ($childrenRequired as $mandatoryKey) {
                        if (!array_key_exists($mandatoryKey, $value)) {
                            $action->addError(
                                'structure',
                                sprintf('Child %s of %s is required', $mandatoryKey, $key),
                                $errorContext
                            );
                        }
                    }

                    foreach ($value as $vlKey => $vlValue) {
                        if (!in_array($vlKey, $childrenRequired)) {
                            $action->addError(
                                'structure',
                                sprintf('Unknown %s key', $vlKey),
                                $errorContext
                            );

                            continue 2;
                        }

                        if ('language' === $vlKey) {
                            if (!is_string($vlValue)) {
                                if (!in_array($vlKey, $childrenRequired)) {
                                    $action->addError(
                                        'structure',
                                        sprintf('Child %s of %s must be type of "string", given %s', $vlKey, $key, gettype($value)),
                                        $errorContext
                                    );
                                }
                            }

                            continue 2;
                        }

                        if ('questions_peer_category' === $vlKey) {
                            if (!is_int($vlValue)) {
                                $action->addError(
                                    'structure',
                                    sprintf('Child %s of %s must be type of "integer", given %s', $vlKey, $key, gettype($value)),
                                    $errorContext
                                );
                            }

                            continue 2;
                        }
                    }
                }
            }
        }

        foreach ($collector as $properties => $elements) {
            list($training, $property) = explode('=', $properties);

            foreach (array_count_values($elements) as $count) {

                if ($count > 1) {
                    $action->addError(
                        'integrity',
                        sprintf('A training has already the same %s', $property),
                        [
                            'file_name' => 'context.yml',
                            'training' => $training
                        ]
                    );
                }
            }
        }
    }

    /**
     * @param \SplFileInfo $file
     */
    protected function getCurrentTraining(\SplFileInfo $file)
    {
        $fragment = explode('/', $file->getPathName());

        return $fragment[count($fragment) - 2];
    }
}
