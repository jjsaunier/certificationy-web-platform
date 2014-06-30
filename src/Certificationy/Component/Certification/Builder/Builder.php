<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Builder;

use Certificationy\Component\Certification\Collector\Collector;
use Certificationy\Component\Certification\Collector\CollectorInterface;
use Certificationy\Component\Certification\Context\CertificationContext;

class Builder
{
    /**
     * @var BuilderPassInterface[]
     */
    protected $builderPass;

    /**
     * @var CollectorInterface
     */
    protected $collector;

    /**
     * @var CertificationContext
     */
    protected $certificationContext;

    /**
     * @param CertificationContext $certificationContext
     * @param CollectorInterface   $collector
     */
    public function __construct(CertificationContext $certificationContext, CollectorInterface $collector = null)
    {
        $this->collector = null === $collector ? new Collector() : $collector;
        $this->builderPass = array();
        $this->certificationContext = $certificationContext;
    }

    public function addCategory()
    {
        return $this;
    }

    public function addQuestion()
    {
        return $this;
    }

    public function addAnswer()
    {
        return $this;
    }

    /**
     * @param BuilderPassInterface $builderPass
     *
     * @return $this
     */
    public function addBuilderPass(BuilderPassInterface $builderPass)
    {
        $this->builderPass[] = $builderPass;

        return $this;
    }

    public function build()
    {
        foreach($this->builderPass as $pass){
            $this->collector->addResources($pass->execute($this, $this->certificationContext));
        }
    }
} 