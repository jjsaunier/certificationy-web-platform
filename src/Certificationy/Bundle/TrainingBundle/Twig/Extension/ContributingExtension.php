<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Twig\Extension;

use Certificationy\Bundle\TrainingBundle\Manager\CertificationManager;
use Symfony\Bundle\TwigBundle\Loader\FilesystemLoader;

class ContributingExtension extends \Twig_Extension
{
    /**
     * @var FilesystemLoader
     */
    protected $loader;

    /**
     * @var string
     */
    protected $baseDir;

    /**
     * @param FilesystemLoader $loader
     * @param                  $baseDir
     */
    public function __construct(FilesystemLoader $loader, $baseDir)
    {
        $this->loader = $loader;
        $this->baseDir = $baseDir;
    }

    /**
     * @param CertificationManager $certificationManager
     */
    public function addCertificationTemplateDir(CertificationManager $certificationManager)
    {
        foreach (array_keys($certificationManager->getCertifications()) as $certificationName) {
            $this->loader->addPath($this->baseDir.'/'.$certificationName, $certificationName);
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'training_contribution_extension';
    }
}
