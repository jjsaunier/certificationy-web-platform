<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
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
     */
    protected function loadFile(\SplFileInfo $file)
    {
        $filename = explode('.', $file->getFilename());
        $content = Yaml::parse(file_get_contents($file->getRealPath()));
        $this->addResource($filename[0], $content);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'yaml';
    }
}
