<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Translation\Translator;

class TrainingBuilder
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
    public function createTrainingMenu(Request $request)
    {
        $menu = $this->factory->createItem('training');

        if (false === $this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
            return $menu;
        }

        $trainingMenu = $menu->addChild('training', array(
            'label' => $this->translator->trans('training.menu', array(), 'training')
        ));

        $trainingMenu->addChild('new_session', array(
            'route' => 'session_index',
            'label' => '.icon-tower '.$this->translator->trans('training.new_session', array(), 'training')
        ));

        return $menu;
    }
} 