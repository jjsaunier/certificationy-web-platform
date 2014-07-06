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
use Certificationy\Component\Certy\Model\Certification;
use Symfony\Component\HttpFoundation\Request;

class TrainingController extends AbstractController
{
    /**
     * @var CertificationManager
     */
    protected $certification;

    /**
     * @param CertificationManager $certificationManager
     */
    public function __construct(Certification $certification)
    {
        $this->certification = $certification;
    }

    /**
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $this->menuBuilder->getChild('training')->setCurrent(true);

        $response = $this->engine->renderResponse('CertificationyTrainingBundle:Session:index.html.twig', array(
            'certification_metrics' => $this->certification->getMetrics()
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
