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

class JsonProvider extends Provider
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @return Resource[]
     */
    public function load()
    {
        $finder = new Finder();
        $finder->files()->in($this->path);
        $resources = array();

        foreach ($finder as $file) {
            $filename = explode('.', $file->getFilename());
            $content = json_decode(file_get_contents($file->getRealPath()), true);
            $resources[] = new Resource($filename[0], $this->getName(), $content);
        }

        return $resources;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'json';
    }
}
