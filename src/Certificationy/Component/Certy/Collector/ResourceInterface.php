<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Collector;

interface ResourceInterface
{
    /**
     * @return string
     */
    public function getProviderName();
    /**
     * @return string
     */
    public function getResourceName();

    /**
     * @return array
     */
    public function getContent();

    /**
     * @param string $certificationName
     */
    public function setCertificationName($certificationName);

    /**
     * @return string
     */
    public function getCertificationName();
} 