<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\WebBundle\Controller;

use Knp\Menu\MenuItem;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\SecurityContext;

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
     * @var MenuItem
     */
    protected $menuBuilder;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

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
     * @param MenuItem $menuBuilder
     */
    public function setMenuBuilder(MenuItem $menuBuilder)
    {
        $this->menuBuilder = $menuBuilder;
    }

    /**
     * @param \Symfony\Component\Security\Core\SecurityContext $securityContext
     */
    public function setSecurityContext($securityContext)
    {
        $this->securityContext = $securityContext;
    }

    /**
     * @return \Symfony\Component\Security\Core\SecurityContext
     */
    public function getSecurityContext()
    {
        return $this->securityContext;
    }
}
