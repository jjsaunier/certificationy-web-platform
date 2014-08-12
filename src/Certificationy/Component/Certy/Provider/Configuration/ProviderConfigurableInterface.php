<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Provider\Configuration;

interface ProviderConfigurableInterface
{
    /**
     * @return FileProviderConfiguration
     */
    public function getConfig();

    /**
     * @param  array $options
     * @return void
     */
    public function setOptions(array $options = []);
}
