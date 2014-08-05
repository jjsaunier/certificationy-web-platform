<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Menu;

use Certificationy\Bundle\TrainingBundle\Manager\CertificationManager;
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
     * @var \Certificationy\Bundle\TrainingBundle\Manager\CertificationManager
     */
    protected $certificationManager;

    /**
     * @param FactoryInterface     $factory
     * @param Translator           $translator
     * @param SecurityContext      $securityContext
     * @param CertificationManager $certificationManager
     */
    public function __construct(
        FactoryInterface $factory,
        Translator $translator,
        CertificationManager $certificationManager
    ) {
        $this->translator = $translator;
        $this->factory = $factory;
        $this->certificationManager = $certificationManager;
    }

    /**
     * @param Request $request
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createTrainingMenu(Request $request)
    {
        $menu = $this->factory->createItem('training');

        $trainingMenu = $menu->addChild('training', array(
            'label' => $this->translator->trans('training.menu', array(), 'training')
        ));

        foreach ($this->certificationManager->getCertifications() as $certificationName => $certificationLabel) {
            $trainingMenu->addChild($certificationName, array(
                'route' => 'certification_guidelines',
                'routeParameters' => array('name' => $certificationName),
                'label' => $certificationLabel
            ));
        }

        return $menu;
    }
}
