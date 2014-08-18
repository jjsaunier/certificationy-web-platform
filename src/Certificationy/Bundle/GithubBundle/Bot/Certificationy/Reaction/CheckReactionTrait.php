<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Bot\Certificationy\Reaction;

use Symfony\Component\Finder\Finder;

trait CheckReactionTrait
{
    /**
     * @param string $basePath
     *
     * @return Finder
     */
    protected function getFiles($basePath)
    {
        $finder = new Finder();

        return $finder->in($basePath.'/*/yaml')->name('*.yml');
    }

    /**
     * @param \SplFileInfo $file
     */
    protected function getCurrentTraining(\SplFileInfo $file)
    {
        $fragment = explode('/', $file->getPathName());

        return $fragment[count($fragment) - 3];
    }
}
