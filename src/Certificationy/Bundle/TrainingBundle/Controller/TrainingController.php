<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Controller;

use Certificationy\Bundle\TrainingBundle\Manager\CertificationManager;
use Certificationy\Bundle\WebBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TrainingController extends AbstractController
{
    /**
     * @var CertificationManager
     */
    protected $certificationManager;

    /**
     * @param CertificationManager $certificationManager
     */
    public function __construct(CertificationManager $certificationManager)
    {
        $this->certificationManager = $certificationManager;
    }

    /**
     * @param Request $request
     * @param         $name
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request, $name)
    {
        $this->menuBuilder->getChild('training')->setCurrent(true);

        $certification = $this->certificationManager->getCertification($name);

        $response = $this->engine->renderResponse('CertificationyTrainingBundle:Session:index.html.twig', array(
            'certification_metrics' => $certification->getMetrics()
        ));

        return $response;
    }

    /**
     * @param Request $request
     */
    public function certificationAction(Request $request)
    {
        $this->menuBuilder->getChild('training')->setCurrent(true);
    }
}
