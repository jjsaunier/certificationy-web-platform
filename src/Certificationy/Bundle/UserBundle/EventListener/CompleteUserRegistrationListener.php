<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\UserBundle\EventListener;

use Certificationy\Bundle\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\SecurityContextInterface;

class CompleteUserRegistrationListener
{
    /**
     * @var SecurityContextInterface
     */
    protected $securityContext;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @param SecurityContextInterface $securityContext
     * @param RouterInterface          $router
     */
    public function __construct(SecurityContextInterface $securityContext, RouterInterface $router)
    {
        $this->securityContext = $securityContext;
        $this->router = $router;
    }
    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        if(HttpKernelInterface::MASTER_REQUEST != $event->getRequestType()){
            return;
        }

        $token = $this->securityContext->getToken();

        if(null === $token || $token instanceof AnonymousToken){
            return;
        }

        $user = $token->getUser();

        if(!$user instanceof User){
            return;
        }

        $request = $event->getRequest();

        if('certificationy_complete_registration' === $request->attributes->get('_route')){
            return;
        }

        if(null === $user->getRealName() || null === $user->getEmail()){
            $event->setResponse(new RedirectResponse($this->router->generate('certificationy_complete_registration')));
        }
    }
} 