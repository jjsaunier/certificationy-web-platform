<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends BaseController
{
    /**
     * @param Request $request
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     */
    public function completeRegistrationAction(Request $request)
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $formHandler = $this->container->get('certificationy.user.complete_registration_form.handler');

        if($formHandler->process($user)){
            $router = $this->container->get('router');
            return new RedirectResponse($router->generate('homepage'));
        }

        return $this->container->get('templating')->renderResponse('@CertificationyUser/Registration/complete_registration.html.twig', array(
            'form' => $formHandler->createView(),
        ));
    }
} 