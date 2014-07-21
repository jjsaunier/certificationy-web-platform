<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\Controller;

use Certificationy\Bundle\CertyBundle\Exception\CheaterException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CertyController extends Controller
{
    /**
     * @param Request $request
     */
    public function guidelinesAction(Request $request, $name)
    {
        $certificationManager = $this->container->get('certificationy.certification.manager');
        $contextHandler = $this->container->get('certy.certification.context.form_handler');

        $certification = $certificationManager->getCertification($name);

        if ($contextHandler->process($certification)) {
            $request->getSession()->set('certification', $certification);
            $router = $this->container->get('router');

            return new RedirectResponse($router->generate('certification_test', array('name' => $name)));
        }

        return $this->render('CertificationyCertyBundle:Certification:guidelines.html.twig', array(
            'certification' => $certification,
            'form' => $contextHandler->createView()
        ));
    }

    /**
     * @param Request $request
     * @param string  $name
     * @TODO: Use esi for this method
     */
    public function testAction(Request $request, $name)
    {
        $certification = $request->getSession()->get('certification');

        if (null === $certification) {
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }

        $certificationHandler = $this->container->get('certy.certification.form_handler');
        $response = new Response();

//        if (!$request->isMethod('POST')) {
//            $response->setPublic();
//            $response->setEtag(md5(serialize($certification)));
//
//            if ($response->isNotModified($request)) {
//                return $response;
//            }
//        }

        if ($certification = $certificationHandler->process($certification)) {
            $router = $this->container->get('router');

            return new RedirectResponse(
                $router->generate('certification_report',
                array('name' => $name)
            ));
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
    public function reportAction(Request $request)
    {
        $certification = $request->getSession()->get('certification');

        //Prevent sneaky people.
        $request->getSession()->remove('certification');

        if (null === $certification) {
            throw new CheaterException;
        }

        return $this->render('CertificationyCertyBundle:Certification:report.html.twig', array(
            'certification' => $certification
        ));
    }
}
