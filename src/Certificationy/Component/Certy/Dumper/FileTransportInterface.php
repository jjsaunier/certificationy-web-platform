<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Dumper;

interface FileTransportInterface
{
    /**
     * @param $filename
     *
     * @return string
     */
    public function getFilePath($filename);

    /**
     * @return string
     */
    public function getPath();
    /**
     * @return string
     */
    public function getFileName();

    /**
     * @return string
     */
    public function getFileExtension();
}
