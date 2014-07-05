<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Manager;

use Certificationy\Component\Certy\Builder\Builder;
use Certificationy\Component\Certy\Builder\ProviderBuildPass;
use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Dumper\PhpDumper;
use Certificationy\Component\Certy\Factory\CertificationFactory;
use Certificationy\Component\Certy\Loader\PhpLoader;
use Certificationy\Component\Certy\Provider\JsonProvider;
use Certificationy\Component\Certy\Provider\ProviderRegistry;
use Certificationy\Component\Certy\Provider\YamlProvider;

class CertificationManager
{
    /**
     * @var string
     */
    protected $dataPath;

    /**
     * @var string
     */
    protected $kernelCacheDir;

    /**
     * @param string $dataPath
     */
    public function __construct($dataPath, $kernelCacheDir)
    {
        $this->dataPath = $dataPath;
        $this->kernelCacheDir = $kernelCacheDir;
    }

    /**
     */
    public function getCertification($certificationName)
    {

    }

    /**
     * @return \Certificationy\Component\Certy\Model\Certification
     */
    public function createCertification()
    {
        $certificationName = 'symfony2';

        $certificationContext = new CertificationContext($certificationName);
        $certificationContext->setNumberOfQuestions(100);
        $certificationContext->setScore(50);
        $certificationContext->setLanguage('en');
        $certificationContext->setDebug(true);
        $certificationContext->setThreshold(array(
                array('newbie' => 30),
                array('beginner' => 45),
                array('not_bad' => 50),
                array('good' => 75),
                array('very_good' => 85),
                array('expert' => 95),
                array('jesus_christ' => 100)
        ));

        $providerRegistry = new ProviderRegistry();
        $providerRegistry->addProvider(new YamlProvider($this->dataPath.'/YAML'), $certificationName);
        $providerRegistry->addProvider(new JsonProvider($this->dataPath.'/JSON'), $certificationName);

        $builder = new Builder();
        $builder->addBuilderPass(new ProviderBuildPass($providerRegistry));

        $certificationFactory = new CertificationFactory();
        $certificationFactory
            ->setBuilder($builder)
            ->setLoader(new PhpLoader($this->kernelCacheDir, 'certificationy'))
            ->setDumper(new PhpDumper($this->kernelCacheDir))
            ->setProviderRegistry($providerRegistry)
        ;

        return $certificationFactory->createNamed('symfony2', $certificationContext);
    }
}
