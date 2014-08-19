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
     * @param Client               $redisClient
     * @param Serializer           $serializer
     */
    public function __construct(
        CertificationFactory $factory,
        Builder $builder,
        Client $redisClient,
        Serializer $serializer
    ) {
        $this->factory = $factory;
        $this->builder = $builder;
        $this->redisClient = $redisClient;
        $this->serializer = $serializer;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

    /**
     * @param string $kernelDebug
     */
    public function setKernelDebug($kernelDebug)
    {
        $this->kernelDebug = $kernelDebug;
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

            $names = [];

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
            ['yaml']
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
            $context->setNumberOfQuestions($contextConfig['defaults']['questions_peer_category']);
            $context->setAllowCustomNumberOfQuestions($contextConfig['customize']['number_of_questions']);
            $context->setDebug($this->kernelDebug);

            $context->setAllowExcludeCategories($contextConfig['customize']['exclude_categories']);

            if (null !== $availableContext = $contextConfig['availableLevels']) {
                $context->setAvailableLevels($availableContext);
                $context->setLevel($contextConfig['defaults']['level']);
            }

            if (null !== $contextConfig['threshold']) {
                $context->setThreshold($contextConfig['threshold']);
            }

            if (null !== $contextConfig['icons']) {
                $context->setIcons($contextConfig['icons']);
            }

            $this->redisClient->set($key, $this->serializer->serialize($context, 'json'));
        }

        $serializedContext = $this->redisClient->get($key);

        /** @PHP|5.5. */

        return $this->serializer->deserialize($serializedContext, CertificationContext::class, 'json');
    }
}
