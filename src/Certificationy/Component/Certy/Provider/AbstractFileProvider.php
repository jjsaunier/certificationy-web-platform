<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Provider;

use Certificationy\Component\Certy\Provider\Configuration\FileProviderConfiguration;
use Symfony\Component\Finder\Finder;

abstract class AbstractFileProvider extends AbstractProvider implements FileProviderInterface
{
    /**
     * @var FileProviderConfiguration
     */
    private $config;

    /**
     * @param \SplFileInfo $file
     */
    abstract protected function loadFile(\SplFileInfo $file);

    /**
     * @return FileProviderConfiguration
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return FileProviderConfiguration
     */
    protected function createProviderConfiguration(Array $options = array())
    {
        return new FileProviderConfiguration($options);
    }

    /**
     * @param array $options
     */
    public function setOptions(Array $options = array())
    {
        $this->config = $this->createProviderConfiguration($options);
    }

    public function load()
    {
        $options = $this->getConfig()->getOptions();

        $finder = new Finder();
        $finder->files()->in($options['path']);

        foreach ($finder as $file) {
            $this->loadFile($file);
        }
    }
}
