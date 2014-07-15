<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Controller;

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

        //Clear previous session when we are at the point to start new one
        if($request->getSession()->has('certification')){
            $request->getSession()->remove('certification');
        }

        return $this->render('CertificationyCertyBundle:Certification:guidelines.html.twig', array(
            'certification' => $certification
        ));
    }

    /**
     * @param Request $request
     * @param         $name
     */
    public function testAction(Request $request, $name)
    {
        $certificationHandler = $this->container->get('certy.certification.form_handler');

        $certificationManager = $this->container->get('certificationy.certification.manager');
        $certification = $certificationManager->getCertification($name);

        //Handle form
        if ($certification = $certificationHandler->process($certification)) {

            //today is enough
            $request->getSession()->set('certification', $certification);

            //Let's see the result
            return $this->forward('CertificationyCertyBundle:Certy:report');
        }

        return $this->render('CertificationyCertyBundle:Certification:test.html.twig', array(
            'certification' => $certification,
            'form' => $certificationHandler->createView()
        ));
    }

    /**
     * @param Request $request
     */
    public function reportAction(Request $request)
    {
        $certification = $request->getSession()->get('certification');

        //Certification does'nt exist in session
        if(null === $certification){
            $router = $this->container->get('router');

//            return new RedirectResponse();
        }

        return $this->render('@CertificationyCerty/Certification/report.html.twig', array(
            'certification' => $certification
        ));
    }
}
