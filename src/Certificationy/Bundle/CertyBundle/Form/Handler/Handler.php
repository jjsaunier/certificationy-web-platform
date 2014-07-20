<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Form\Handler;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Handler
{
    /**
     * @var FormFactory
     */
    protected $factory;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var array
     */
    protected $options = array();

    /**
     * @var null|FormInterface
     */
    protected $form = null;

    /**
     * @var string
     */
    protected $method;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @param FormFactoryInterface $factory
     */
    public function setFormFactory(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @return FormInterface
     * @throws \Exception
     */
    public function getForm()
    {
        if (null === $this->form) {
            throw new \Exception('You must create form before retrieve it');
        }

        return $this->form;
    }

    /**
     * @param null  $data
     * @param array $options
     */
    public function createForm($data = null, array $options = array())
    {
        if (null !== $data) {
            $this->options['data'] = $data;
        }

        $this->form = $this->factory->create($this->name, null, array_merge($this->options, $options));
    }

    /**
     * @return mixed
     */
    public function createView()
    {
        return $this->form->createView();
    }

    /**
     * @param string $method
     *
     * @return bool
     */
    public function handle($method = 'POST')
    {
        $request = $this->requestStack->getCurrentRequest();

        $form = $this->form;
        $this->setMethod($method);

        $form->handleRequest($request);

        if ($form->isValid()) {
            return $this->onSuccess($form->getData());
        }

        return $this->onError($form->getData());
    }

    /**
     * @param $data
     */
    protected function onSuccess($data)
    {
        return true; //stub to avoid make it abstracted
    }

    /**
     * @param $data
     */
    protected function onError($data)
    {
        return false; //stub to avoid make it abstracted
    }
}
