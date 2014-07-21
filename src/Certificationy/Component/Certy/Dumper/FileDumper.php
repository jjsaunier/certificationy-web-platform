<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Dumper;

use Symfony\Component\Filesystem\Filesystem;

class FileDumper extends AbstractDumper
{
    /**
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var string|null
     */
    protected $cacheDir;

    /**
     * @var string
     */
    protected $cacheDirName;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @param string     $cacheDir
     * @param null       $cacheDirName
     * @param Filesystem $filesystem
     */
    public function __construct(
        $cacheDir = null,
        $cacheDirName = null,
        Filesystem $filesystem = null
    ) {
        $this->filesystem = null === $filesystem ? new Filesystem() : $filesystem;
        $this->cacheDir = null === $cacheDir ? sys_get_temp_dir() : $cacheDir;
        $this->cacheDirName = null === $cacheDirName ? 'certificationy' : $cacheDirName;
    }

    /**
     * @param string $filename
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
        return $this->context->getName().$this->getFileExtension();
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return '';
    }

    /**
     * @param string $filename
     * @param string $rawData
     */
    protected function dumpFile($filename, $rawData)
    {
        $this->filesystem->dumpFile($filename, $rawData);
    }
}
