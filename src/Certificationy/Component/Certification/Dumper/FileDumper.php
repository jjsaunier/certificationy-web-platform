<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Dumper;

use Certificationy\Component\Certification\Model\Certification;
use Certificationy\Component\Certification\Context\CertificationContext;
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
     * @param Certification        $certification
     * @param CertificationContext $certificationContext
     * @param null|string          $cacheDir
     * @param null|string          $cacheDirName
     * @param Filesystem           $filesystem
     */
    public function __construct(
        Certification $certification,
        CertificationContext $certificationContext,
        $cacheDir = null,
        $cacheDirName = null,
        Filesystem $filesystem = null
    ) {
        parent::__construct($certification, $certificationContext);

        $this->filesystem = null === $filesystem ? new Filesystem() : $filesystem;
        $this->cacheDir = null === $cacheDir ? sys_get_temp_dir() : $cacheDir;
        $this->cacheDirName = null === $cacheDirName ? 'certificationy' : $cacheDirName;
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
        return $this->certificationContext->getName().$this->getFileExtension();
    }

    /**
     * @return string
     */
    public function getFileExtension()
    {
        return '';
    }

    /**
     * @return mixed
     */
    public function dump()
    {
        $this->dumpFile($this->getFilePath($this->getFileName()), $this->doDump());
    }

    /**
     * @param string $filename
     * @param mixed  $rawData
     */
    protected function dumpFile($filename, $rawData)
    {
        $this->filesystem->dumpFile($filename, $rawData);
    }
}
