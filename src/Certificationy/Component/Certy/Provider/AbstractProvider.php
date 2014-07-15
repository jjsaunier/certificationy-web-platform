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

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var Resource[]
     */
    protected $resources;

    /**
     * @param string $resourceName
     * @param string $certificationName
     * @param mixed  $content
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function addResource($resourceName, $certificationName, $content)
    {
        if (!is_array($content) || empty($content)) {
            throw new \Exception(sprintf('Provider %s return unexpected result', $this->getName()));
        }

        $this->resources[] = new Resource($this->getName(), $certificationName, $resourceName, $content);
    }

    /**
     * @return Resource[]
     */
    public function getResources()
    {
        return $this->resources;
    }
}
