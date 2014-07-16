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
use Symfony\Component\HttpFoundation\Response;

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
     * @TODO: Use esi for this method
     */
    public function testAction(Request $request, $name)
    {
        $certificationHandler = $this->container->get('certy.certification.form_handler');
        $certificationManager = $this->container->get('certificationy.certification.manager');
        $certification = $certificationManager->getCertification($name);

        $response = new Response();

//        if(!$request->isMethod('POST')){
//            $response->setPublic();
//            $response->setEtag(md5(serialize($certification)));
//
//            if ($response->isNotModified($request)) {
//                return $response;
//            }
//        }

        if ($certification = $certificationHandler->process($certification)) {
            return $this->reportAction($request, $certification);
        }

        $content = $this->renderView('CertificationyCertyBundle:Certification:test.html.twig', array(
            'certification' => $certification,
            'form' => $certificationHandler->createView()
        ));

        $response->setContent($content);

        return $response;
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
