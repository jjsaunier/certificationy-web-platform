<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Provider\Configuration;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FileProviderConfiguration extends ProviderConfiguration
{
    /**
     * @param OptionsResolver $resolver
     *
     * @return mixed|void
     */
    public function configure(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'path'
        ]);

        $resolver->setOptional([
            'pattern'
        ]);

        $resolver->setAllowedTypes([
            'path' => ['array', 'string'],
            'pattern' => ['string']
        ]);

        $resolver->setNormalizers([
            'path' => function (Options $options, $value) {
                if (!is_array($value)) {
                    $value = (array) $value;
                }

                return $value;
            }
        ]);
    }
}
