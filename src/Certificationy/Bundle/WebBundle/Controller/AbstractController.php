<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

class AbstractController
{
    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var UrlGeneratorInterface
     */
    protected $router;

    /**
     * @var EngineInterface
     */
    protected $engine;

    /**
     * @var Array
     */
    protected $menuCollection;

    /**
     * @param RequestStack $requestStack
     */
    public function setRequestStack(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * @param RouterInterface $router
     */
    public function setRouter(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @param EngineInterface $engine
     */
    public function setEngine(EngineInterface $engine)
    {
        $this->engine = $engine;
    }

    /**
     */
    public function setMenuCollection(Array $menuCollection)
    {
        $this->menuCollection = $menuCollection;
    }
}
