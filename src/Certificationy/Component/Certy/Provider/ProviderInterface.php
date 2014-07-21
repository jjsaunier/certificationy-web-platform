<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Provider;

interface ProviderInterface
{
    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $resourceName
     * @param string $certificationName
     * @param mixed  $content
     *
     * @return mixed|void
     * @throws \Exception
     */
    public function addResource($resourceName, $certificationName, $content);

    /**
     * @return Resource[]
     */
    public function getResources();

    /**
     * @param  string     $certificationName
     * @return Resource[]
     */
    public function load($certificationName);
}
