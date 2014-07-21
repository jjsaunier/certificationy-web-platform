<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Context;

/**
 * In the first approach, I was not convicted by adding a registry class for context
 * but in real situation, she is really appreciate, that avoid to have a CertificationContext dependency in controller
 * and the most part, it's you can call dynamically many predefined certification from only one controller method.
 *
 * If somebody find a better way to kept these features without this registry, i'm really interested.
 */
class ContextRegistry
{
    /**
     * @var CertificationContextInterface[]
     */
    protected $contexts;

    /**
     * @param CertificationContextInterface $context
     */
    public function addContext(CertificationContextInterface $context)
    {
        $this->contexts[$context->getName()] = $context;
    }

    /**
     * @param  string                        $name
     * @return CertificationContextInterface
     */
    public function getContext($name)
    {
        if (!isset($this->contexts[$name])) {
            throw new \Exception(sprintf(
                'Context %s is not registered, available are [ %s ]',
                $name,
                implode(', ', array_keys($this->contexts))
            ));
        }

        return $this->contexts[$name];
    }

    /**
     * @return CertificationContextInterface[]
     */
    public function getContexts()
    {
        return $this->contexts;
    }

    /**
     * @return integer[]
     */
    public function getCertificationNames()
    {
        return array_keys($this->contexts);
    }
}
