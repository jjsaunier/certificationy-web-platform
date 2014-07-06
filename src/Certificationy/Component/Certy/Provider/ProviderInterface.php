<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
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
     * @param $filename
     * @param $content
     *
     * @return mixed
     */
    public function addResource($filename, $content);

    /**
     * @return Resource[]
     */
    public function getResources();

    /**
     * @return Resource[]
     */
    public function load();
}
