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
use Certificationy\Component\Certy\Builder\ProviderBuilderPass;
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
     * @var \Certificationy\Component\Certy\Factory\CertificationFactory
     */
    protected $certificationFactory;

    /**
     * @param string $dataPath
     */
    public function __construct(CertificationFactory $certificationFactory)
    {
        $this->certificationFactory = $certificationFactory;
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
        $certificationContext = new CertificationContext('symfony2');
        $certificationContext->setNumberOfQuestions(100);
        $certificationContext->setScore(50);
        $certificationContext->setLanguage('en');
        $certificationContext->setDebug(false);
        $certificationContext->setThreshold(array(
                array('newbie' => 30),
                array('beginner' => 45),
                array('not_bad' => 50),
                array('good' => 75),
                array('very_good' => 85),
                array('expert' => 95),
                array('jesus_christ' => 100)
        ));


        //Example with CertyBundle
        return $this->certificationFactory->createNamed('symfony2', $certificationContext);

//        Example with Certy component


//        $certificationName = 'symfony2';
//        $dataPath = '/home/johann/Projects/CERIFICATIONY-WEB-PLATEFORME/Certificationy/app/../src/Certificationy/Certification/Data';
//        $cachePath = '/home/johann/Projects/CERIFICATIONY-WEB-PLATEFORME/Certificationy/app/cache/dev';
//
//        $providerRegistry = new ProviderRegistry();
//
//        $yamlProvider = new YamlProvider();
//        $yamlProvider->setOptions(array(
//            'path' => $dataPath.'/YAML'
//        ));
//
//        $jsonProvider = new JsonProvider();
//        $jsonProvider->setOptions(array(
//            'path' => $dataPath.'/JSON'
//        ));
//
//        $providerRegistry->addProvider($yamlProvider, $certificationName);
//        $providerRegistry->addProvider($jsonProvider, $certificationName);
//
//        $builder = new Builder();
//        $builder->addBuilderPass(new ProviderBuilderPass($providerRegistry));
//
//        $certificationFactory = new CertificationFactory();
//        $certificationFactory
//            ->setBuilder($builder)
//            ->setLoader(new PhpLoader($cachePath, 'certificationy'))
//            ->setDumper(new PhpDumper($cachePath))
//            ->setProviderRegistry($providerRegistry)
//        ;
//
//       return $certificationFactory->createNamed('symfony2', $certificationContext);
    }
}
