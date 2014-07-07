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

class ProviderConfiguration implements ProviderConfigurationInterface
{
    /**
     * @var array
     */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(Array $options = array())
    {
        $resolver = new OptionsResolver();

        $this->configure($resolver);
        $this->options = $resolver->resolve($options);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configure(OptionsResolver $resolver)
    {

    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
