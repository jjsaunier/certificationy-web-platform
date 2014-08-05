<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Manager;

use Certificationy\Component\Certy\Builder\Builder;
use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Factory\CertificationFactory;
use JMS\Serializer\Serializer;
use Predis\Client;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Parser;

class CertificationManager
{
    /**
     * @var \Certificationy\Component\Certy\Factory\CertificationFactory
     */
    protected $factory;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var bool
     */
    protected $kernelDebug;

    /**
     * @var Client
     */
    protected $redisClient;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @param CertificationFactory $factory
     * @param Builder              $builder
     * @param bool                 $kernelDebug
     * @param Client               $redisClient
     * @param Serializer           $serializer
     */
    public function __construct(
        CertificationFactory $factory,
        Builder $builder,
        $kernelDebug,
        Client $redisClient,
        Serializer $serializer
    ) {
        $this->factory = $factory;
        $this->builder = $builder;
        $this->kernelDebug = $kernelDebug;
        $this->redisClient = $redisClient;
        $this->serializer = $serializer;
    }

    /**
     * @param $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @return string[]
     */
    public function getCertifications()
    {
        $key = 'available_training';

        if (!$this->redisClient->exists($key)) {
            $finder = new Finder();
            $files = $finder->files()->in($this->basePath.'/*')->name('context.yml');
            $yaml = new Parser();

            $names = array();

            foreach ($files as $file) {
                $context = $yaml->parse(file_get_contents($file->getRealPath()));
                $names[$context['name']] = $context['label'];
            }

            $this->redisClient->set($key, json_encode($names));
        }

        return json_decode($this->redisClient->get($key), true);
    }

    /**
     * @param $name
     *
     * @return \Certificationy\Component\Certy\Model\Certification
     */
    public function getCertification($name, CertificationContext $certificationContext = null)
    {
        return $this->factory->createNamed(
            $name,
            null === $certificationContext ? $this->getContext($name) : $certificationContext,
            array('yaml')
        );
    }

    /**
     * @param $name
     *
     * May I should move it to certy component as context builder ???
     *
     * @return CertificationContext
     */
    public function getContext($name)
    {
        $content = file_get_contents($this->basePath.'/'.$name.'/context.yml');
        $key = 'context_'.$name.'::'.sha1($content);

        if (!$this->redisClient->exists($key)) {
            $yaml = new Parser();
            $contextConfig = $yaml->parse($content);

            $context = new CertificationContext($contextConfig['name']);
            $context->setLabel($contextConfig['label']);
            $context->setAvailableLanguages($contextConfig['availableLanguages']);
            $context->setLanguage($contextConfig['defaults']['language']);
            $context->setDebug($this->kernelDebug);
            $context->setNumberOfQuestions($contextConfig['numberOfQuestions']);
            $context->setAllowCustomNumberOfQuestions($contextConfig['allowCustomNumberOfQuestions']);

            $context->setAllowExcludeCategories($contextConfig['allowExcludeCategories']);

            if (null !== $availableContext = $contextConfig['availableLevels']) {
                $context->setAvailableLevels($availableContext);
                $context->setLevel($contextConfig['defaults']['level']);
            }

            if (null !== $contextConfig['threshold']) {
                $context->setThreshold($contextConfig['threshold']);
            }

            $this->redisClient->set($key, $this->serializer->serialize($context, 'json'));
        }

        $serializedContext = $this->redisClient->get($key);

        /** @PHP|5.5. */

        return $this->serializer->deserialize($serializedContext, CertificationContext::class, 'json');
    }
}
