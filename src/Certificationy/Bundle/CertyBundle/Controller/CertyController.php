<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\Controller;

use Certificationy\Component\Certy\Events\CertificationEvent;
use Certificationy\Component\Certy\Events\CertificationEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CertyController extends Controller
{
    /**
     * @param Request $request
     * @param string  $name
     *
     * @return RedirectResponse|Response
     */
    public function guidelinesAction(Request $request, $name)
    {
        $certificationManager = $this->container->get('certificationy.certification.manager');
        $contextHandler = $this->container->get('certy.certification.context.form_handler');

        $certification = $certificationManager->getCertification($name);

        if ($contextHandler->process($certification)) {
            $request->getSession()->set('certification', $certification);
            $router = $this->container->get('router');

            $eventDispatcher = $this->container->get('event_dispatcher');
            $eventDispatcher->dispatch(CertificationEvents::CERTIFICATION_START, new CertificationEvent($certification));

            return new RedirectResponse($router->generate('certification_test', ['name' => $name]));
        }

        return $this->render('CertificationyCertyBundle:Certification:guidelines.html.twig', [
            'certification' => $certification,
            'form' => $contextHandler->createView()
        ]);
    }

    /**
     * @param Request $request
     * @param string  $name
     *
     * @return RedirectResponse|Response
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function testAction(Request $request, $name)
    {
        $certification = $request->getSession()->get('certification');

        if (null === $certification) {
            return $this->forward('CertificationyCertyBundle:Certy:guidelines', [ $request, $name ]);
        }

        $certificationHandler = $this->container->get('certy.certification.form_handler');
        $response = new Response();

        if ($certification = $certificationHandler->process($certification)) {

            $router = $this->container->get('router');

            return new RedirectResponse(
                $router->generate('certification_report',
                ['name' => $name]
            ));
        }

        $content = $this->renderView('CertificationyCertyBundle:Certification:test.html.twig', [
            'certification' => $certification,
            'form' => $certificationHandler->createView()
        ]);

        $response->setContent($content);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function reportAction(Request $request)
    {
        $session = $request->getSession();
        $certification = $session->get('certification');

        if (null === $certification) {
            $router = $this->get('router');

            return new RedirectResponse($router->generate('fos_user_profile_show'));
        }

        //Prevent sneaky people.
        $session->remove('certification');

        return $this->render('CertificationyCertyBundle:Certification:report.html.twig', [
            'certification' => $certification
        ]);
    }
}
