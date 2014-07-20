<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Collector;

class Resource
{
    /**
     * @var string
     */
    protected $resourceName;

    /**
     * @var string
     */
    protected $providerName;

    /**
     * @var string
     */
    protected $certificationName;

    /**
     * @var array
     */
    protected $content;

    /**
     * @param string $providerName
     * @param string $certificationName
     * @param string $resourceName
     * @param array  $content
     */
    public function __construct($providerName, $certificationName, $resourceName, array $content)
    {
        $this->providerName = $providerName;
        $this->certificationName = $certificationName;
        $this->resourceName = $resourceName;
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getProviderName()
    {
        return $this->providerName;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $certificationName
     */
    public function setCertificationName($certificationName)
    {
        $this->certificationName = $certificationName;
    }

    /**
     * @return string
     */
    public function getCertificationName()
    {
        return $this->certificationName;
    }
}
