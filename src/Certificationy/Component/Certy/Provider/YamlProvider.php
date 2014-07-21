<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Provider;

use Symfony\Component\Yaml\Yaml;

class YamlProvider extends AbstractFileProvider
{
    /**
     * @param \SplFileInfo $file
     * @param string       $certificationName
     *
     * @return mixed|void
     */
    protected function loadFile(\SplFileInfo $file, $certificationName)
    {
        $filename = explode('.', $file->getFilename());
        $this->addResource($filename[0], $certificationName, Yaml::parse(file_get_contents($file->getRealPath())));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yaml';
    }
}
