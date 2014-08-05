<?php
namespace Certificationy\Bundle\TrainingBundle\Cache;

use Certificationy\Bundle\TrainingBundle\Manager\CertificationManager;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

class CertificationWarmer implements CacheWarmerInterface
{
    /**
     * @var CertificationManager
     */
    protected $certificationManager;

    /**
     * @param CertificationManager $certificationManager
     */
    public function __construct(CertificationManager $certificationManager)
    {
        $this->certificationManager = $certificationManager;
    }

    /**
     * @return bool
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * @param string $cacheDir
     */
    public function warmUp($cacheDir)
    {
        foreach ($this->certificationManager->getCertifications() as $name => $label) {
            $this->certificationManager->getCertification($name);
        }
    }
}
