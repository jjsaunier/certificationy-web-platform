<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Provider\Configuration;

use Symfony\Component\OptionsResolver\OptionsResolver;

interface ProviderConfigurationInterface
{
    /**
     * @param OptionsResolver $resolver
     *
     * @return mixed
     */
    public function configure(OptionsResolver $resolver);

    /**
     * @return array
     */
    public function getOptions();
} 