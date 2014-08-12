<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\UserBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Translation\Translator;

class UserBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    protected $factory;

    /**
     * @var \Symfony\Component\Translation\Translator
     */
    protected $translator;

    /**
     * @var SecurityContext
     */
    protected $securityContext;

    /**
     * @param FactoryInterface $factory
     * @param Translator       $translator
     * @param SecurityContext  $securityContext
     */
    public function __construct(
        FactoryInterface $factory,
        Translator $translator,
        SecurityContext $securityContext
    ) {
        $this->translator = $translator;
        $this->factory = $factory;
        $this->securityContext = $securityContext;
    }

    /**
     * @param Request $request
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createUserMenu(Request $request)
    {
        $menu = $this->factory->createItem('user');

        if (false === $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            $menu->addChild('login', [
                'route' => 'fos_user_security_login',
                'label' => $this->translator->trans('login', [], 'menu')
            ]);
        } else {
            $user = $this->securityContext->getToken()->getUser();

            $currentUserMenu = $menu->addChild('current_user', [
                'label' => $user->getUsername()
            ]);

            $currentUserMenu->addChild('profile', [
                'route' => 'fos_user_profile_show',
                'label' => '.icon-user '.$this->translator->trans('profile', [], 'menu')
            ]);

            $currentUserMenu->addChild('logout', [
                'route' => 'fos_user_security_logout',
                'label' => '.icon-off '.$this->translator->trans('logout', [], 'menu')
            ]);
        }

        return $menu;
    }
}
