<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Provider;

use Certificationy\Component\Certy\Collector\Resource;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class YamlProvider extends AbstractProvider implements FileProviderInterface
{
    /**
     * @var string[]
     */
    private $paths;

    /**
     * @param string[] $path
     */
    public function __construct(Array $paths)
    {
        $this->paths = $paths;
    }

    /**
     * @param string $path
     */
    public function addPath($path)
    {
        $this->paths[] = $path;
    }

    /**
     * @return Resource[]
     */
    public function load()
    {
        $finder = new Finder();
        $finder->files()->in($this->paths);

        foreach ($finder as $file) {
            $filename = explode('.', $file->getFilename());
            $content = Yaml::parse(file_get_contents($file->getRealPath()));
            $this->addResource($filename[0], $content);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yaml';
    }
}
