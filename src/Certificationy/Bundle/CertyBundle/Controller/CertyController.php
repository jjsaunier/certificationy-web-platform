<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Controller;

use Certificationy\Component\Certy\Model\Certification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CertyController extends Controller
{
    /**
     * @param Request $request
     */
    public function guidelinesAction(Request $request, $name)
    {
        $certificationManager = $this->container->get('certificationy.certification.manager');
        $certification = $certificationManager->getCertification($name);

        return $this->render('CertificationyCertyBundle:Certification:guidelines.html.twig', array(
            'certification' => $certification
        ));
    }

    /**
     * @param Request $request
     * @param string  $name
     */
    public function testAction(Request $request, $name)
    {
        $certificationHandler = $this->container->get('certy.certification.form_handler');
        $certificationManager = $this->container->get('certificationy.certification.manager');

        $certification = $certificationManager->getCertification($name);

        if ($certification = $certificationHandler->process($certification)) {
            return $this->reportAction($request, $certification);
        }

        return $this->render('CertificationyCertyBundle:Certification:test.html.twig', array(
            'certification' => $certification,
            'form' => $certificationHandler->createView()
        ));
    }

    /**
     * @param Request $request
     */
    public function reportAction(Request $request, Certification $certification)
    {
        return $this->render('CertificationyCertyBundle:Certification:report.html.twig', array(
            'certification' => $certification
        ));
    }
}
