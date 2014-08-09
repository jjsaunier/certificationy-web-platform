<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\WebBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class WebBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    protected $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param Request $request
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createWebMenu(Request $request)
    {
        $menu = $this->factory->createItem('web');

        $menu->addChild('help', array(
            'route' => 'help_show',
            'label' => 'Help'
        ));

        return $menu;
    }
} 