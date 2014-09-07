<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Collector;

class Collector implements CollectorInterface
{
    /**
     * @var Resource[]
     *
     * yaml
     *      -> symfony2
     *           -> resource
     *           -> resource
     *           -> resource
     *      -> jquery
     *           -> resource
     * json
     *      -> symfony2
     *           -> resource
     *
     */
    protected $resources;

    /**
     * @var string[]
     */
    protected $collectedProviders;

    public function __construct()
    {
        $this->resources = [];
        $this->collectedProviders = [];
    }

    /**
     * @param string              $providerName
     * @param string              $certificationName
     * @param ResourceInterface[] $resources
     */
    public function addResource($providerName, $certificationName, array $resources)
    {
        if (!in_array($providerName, $this->collectedProviders)) {
            $this->collectedProviders[] = $providerName;
        }

        if (!isset($this->resources[$providerName])) {
            $this->resources[$providerName] = [];
        }

        if (!isset($this->resources[$providerName][$certificationName])) {
            $this->resources[$providerName][$certificationName] = [];
        }

        $currentResource = &$this->resources[$providerName][$certificationName];
        $currentResource = array_merge_recursive($currentResource, $resources);
    }

    /**
     * @param $certificationName
     *
     * @return ResourceInterface[]
     */
    public function getFlattenResources($certificationName)
    {
        $flatten = [];
        foreach ($this->resources as $providerResources) {
            foreach ($providerResources as $certifName => $resources) {
                if ($certificationName === $certifName) {
                    foreach ($resources as $resource) {
                        $flatten[] = $resource;
                    }
                }
            }
        }

        return $flatten;
    }

    /**
     * @return ResourceInterface[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->resources);
    }

    /**
     * @return string[]
     */
    public function getCollectedProviders()
    {
        return $this->collectedProviders;
    }

    /**
     * @return bool
     */
    public function isDirty()
    {
        return null !== $this->resources;
    }

    public function release()
    {
        $this->resources = null;
        $this->collectedProviders = [];
    }
}
