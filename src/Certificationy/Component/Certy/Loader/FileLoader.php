<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Loader;

use Certificationy\Component\Certy\Dumper\FileTransportInterface;
use Symfony\Component\Filesystem\Filesystem;

class FileLoader extends Loader implements FileTransportInterface
{
    /**
     * @var string
     */
    protected $cacheDir;

    /**
     * @var string
     */
    protected $cacheDirName;

    /**
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * @var string
     */
    protected $certificationName;

    /**
     * @param string     $cacheDir
     * @param string     $cacheDirName
     * @param Filesystem $filesystem
     */
    public function __construct($cacheDir, $cacheDirName, Filesystem $filesystem = null)
    {
        $this->cacheDir = $cacheDir;
        $this->cacheDirName = $cacheDirName;
        $this->filesystem = null === $filesystem ? new Filesystem() : $filesystem;
    }

    /**
     * @param string   $certificationName
     *
     * @return mixed
     * @throws \Exception
     */
    public function load($certificationName)
    {
        $this->certificationName = $certificationName;

        if (true === $this->exists($filename = $this->getFilePath($this->getFileName()))) {
            $certification = include $filename;

            if ($this->validate($certification)) {
                if (true === $certification->getContext()->getDebug()) {
                    return false;
                }

                return $certification;
            } else {
                throw new \Exception('You must return Certificationy\Component\Certy\Model\Certification object');
            }
        }
    }

    /**
     * @return string
     */
    public function getCacheDir()
    {
        return $this->cacheDir;
    }

    /**
     * @return string
     */
    public function getCacheDirName()
    {
        return $this->cacheDirName;
    }

    /**
     * @param $filename
     *
     * @return string
     */
    public function getFilePath($filename)
    {
        return $this->getPath().$filename;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->cacheDir.DIRECTORY_SEPARATOR.$this->cacheDirName.DIRECTORY_SEPARATOR;
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        return $this->certificationName.$this->getFileExtension();
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return '';
    }

    /**
     *
     * @return bool
     */
    protected function exists()
    {
        return $this->filesystem->exists($this->getFilePath($this->getFileName()));
    }
}
