<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Manager;

use Certificationy\Component\Certification\Builder\Builder;
use Certificationy\Component\Certification\Builder\ProviderBuildPass;
use Certificationy\Component\Certification\Context\CertificationContext;
use Certificationy\Component\Certification\Dumper\PhpDumper;
use Certificationy\Component\Certification\Loader\CertificationPhpLoader;
use Certificationy\Component\Certification\Model\Certification;
use Certificationy\Component\Certification\Provider\JsonProvider;
use Certificationy\Component\Certification\Provider\ProviderRegistry;
use Certificationy\Component\Certification\Provider\YamlProvider;

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
     * @param string $name
     */
    public function getCertification($certificationName)
    {

    }

    /**
     * @return \Certificationy\Component\Certification\Model\Certification
     */
    public function createCertification()
    {
        /**
         * I use this loader, only because I use PhpDumper !!! It's a cache system.
         * Load certification named 'symfony2' (via CertificationContext)
         */
        $certificationLoader = new CertificationPhpLoader($this->kernelCacheDir, 'certificationy');
        $certification = $certificationLoader->load('symfony2');

        if ($certification instanceof Certification) {
            return $certification;
        }

        /**
         * Setup the context for symfony2 certification, I dont know if it's
         * realistic, it's just for the example
         *
         * With CertificationBundle certificationContext is a service populate via config component
         **/
        $certificationContext = new CertificationContext('symfony2');
        $certificationContext->setNumberOfQuestion(100);
        $certificationContext->setCertificationScore(50);
        $certificationContext->setCertificationLanguage('en');
        $certificationContext->setDebug(true);
        $certificationContext->setCertificationThreshold(array(
                array('newbie' => 30),
                array('beginner' => 45),
                array('not_bad' => 50),
                array('good' => 75),
                array('very_good' => 85),
                array('expert' => 95),
                array('jesus_christ' => 100)
        ));

        /**
         * Load different provider to retrieve our raw data from different place
         * Yaml, DB, Cache, CSV, Dropbox, Evernote ? :D And from space obviously.
         *
         * With CertificationBundle each provider is tagged service e.g : certification.provider
         */
        $providerRegistry = new ProviderRegistry();
        $providerRegistry->addProvider(new YamlProvider($this->dataPath.'/YAML'), 'yaml');
        $providerRegistry->addProvider(new JsonProvider($this->dataPath.'/JSON'), 'json');

        /**
         * Setup our builder, he need context, and at to call builderPass for our Providers
         *
         * With CertificationBundle the builder it's service, with configurator (see symfony service configurator)
         */
        $certificationBuilder = new Builder($certificationContext);
        $certificationBuilder->addBuilderPass(new ProviderBuildPass($providerRegistry));

        /**
         * Here we have Certificationy\Component\Certification\Model\Certification instance, fully hydrated.
         */
        $certification = $certificationBuilder->build();

        /**
         * Extra bonus :
         * Case 1: Share a certification (abstract of the way, we will provide mainly use format) as digital.
         * Case 2: Transform digital certification on physical certification.
         * Case 3: Cache
         */
        $dumper = new PhpDumper($certification, $certificationContext, $this->kernelCacheDir);

//        $dumper->dump('pdf');
//        $dumper->dump('dropbox');
//        $dumper->dump('evernote');
        $dumper->dump('php'); //Cache
//        $dumper->dump('apc');
//        $dumper->dump('sql');
        // ... Whatever
        return $certification;
    }
}
