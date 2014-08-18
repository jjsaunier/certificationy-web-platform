<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class GithubBuilder
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
    public function createInspectionMenu(Request $request)
    {
        $menu = $this->factory->createItem('inspection');

        $menu->addChild('inspection', [
            'route' => 'github_inspection',
            'label' => 'Contribution'
        ]);

        return $menu;
    }
}
