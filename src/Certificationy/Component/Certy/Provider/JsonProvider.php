<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Provider;

class JsonProvider extends AbstractFileProvider
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
        $content = json_decode(file_get_contents($file->getRealPath()), true);

        $this->addResource($filename[0], $certificationName, $content);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'json';
    }
}
