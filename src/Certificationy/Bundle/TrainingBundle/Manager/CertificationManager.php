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
use Psr\Log\LoggerInterface;
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
    protected $debug;

    /**
     * @var Client
     */
    protected $redisClient;

    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param CertificationFactory $factory
     * @param Builder              $builder
     * @param Client               $redisClient
     * @param Serializer           $serializer
     * @param LoggerInterface      $logger
     */
    public function __construct(
        CertificationFactory $factory,
        Builder $builder,
        Client $redisClient,
        Serializer $serializer,
        LoggerInterface $logger
    ) {
        $this->factory = $factory;
        $this->builder = $builder;
        $this->redisClient = $redisClient;
        $this->serializer = $serializer;
        $this->logger = $logger;
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
    public function setDebug($debug)
    {
        $this->debug = $debug;
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

            $this->logger->info(sprintf(
                'load available trainings, available : [%s]',
                implode(', ', $names)
            ));

            $this->redisClient->set($key, json_encode($names));
        }

        $this->logger->debug('Load available trainings from redis server', ['key' => $key]);

        return json_decode($this->redisClient->get($key), true);
    }

    /**
     * @param string               $name
     * @param CertificationContext $certificationContext
     *
     * @return \Certificationy\Component\Certy\Model\Certification
     * @throws \Exception
     */
    public function getCertification($name, CertificationContext $certificationContext = null)
    {
        $this->logger->info(sprintf('Certification %s requested', $name));

        try {
            return $this->factory->createNamed(
                $name,
                null === $certificationContext ? $this->getContext($name) : $certificationContext,
                ['yaml']
            );
        } catch ( \Exception $e) {

            $this->logger->critical(sprintf(
                'An error has been raised when creating certification %s, error : %s inside %s',
                $name,
                $e->getMessage(),
                $e->getFile()
            ));

            throw $e;
        }
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
            $context->setNumberOfQuestions($contextConfig['defaults']['questions_peer_category']);
            $context->setAllowCustomNumberOfQuestions($contextConfig['customize']['number_of_questions']);
            $context->setDebug($this->debug);

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

            $this->logger->info(
                sprintf('Parse context for certification %s', $name, ['key' =>  $key])
            );

            $this->redisClient->set($key, $this->serializer->serialize($context, 'json'));
        }

        $this->logger->debug(
            sprintf('Load certification context %s from redis server', $name, ['key' =>  $key])
        );

        $serializedContext = $this->redisClient->get($key);

        return $this->serializer->deserialize($serializedContext, CertificationContext::class, 'json');
    }
}
