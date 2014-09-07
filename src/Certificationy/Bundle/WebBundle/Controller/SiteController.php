<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\WebBundle\Controller;

use Certificationy\Bundle\TrainingBundle\Manager\CertificationManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Yaml\Parser;

class SiteController extends AbstractController
{
    /**
     * @var string
     */
    protected $kernelRootDir;

    /**
     * @var \Certificationy\Bundle\TrainingBundle\Manager\CertificationManager
     */
    protected $certificationManager;

    /**
     * @param string               $rootDir
     * @param CertificationManager $certificationManager
     */
    public function __construct($rootDir, CertificationManager $certificationManager)
    {
        $this->kernelRootDir = $rootDir;
        $this->certificationManager = $certificationManager;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $response = $this->engine->renderResponse('@CertificationyWeb/Site/homepage.html.twig', [

        ]);

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function menuAction(Request $request)
    {
        return $this->engine->renderResponse('@CertificationyWeb/Menu/nav.html.twig', [
            'menus' => [ 'training', 'github', 'user', 'web' ]
        ]);
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function changelogAction(Request $request)
    {
        $content = file_get_contents($this->kernelRootDir.'/../changelog.yml');

        $response = new Response();
        $response->setPublic();
        $response->setEtag(md5($content));
        $response->setVary('Accept-Encoding', 'User-Agent');

        if (!$response->isNotModified($request)) {
            $parser = new Parser();

            $response->setLastModified(new \DateTime());

            return $this->engine->renderResponse('@CertificationyWeb/Site/changelog.html.twig', [
                'changelog' => $parser->parse($content)
            ]);
        }

        return $response;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function footerAction(Request $request)
    {
        $response = new Response();
        $response->setPublic();
        $response->setSharedMaxAge(600);
        $response->setVary('Accept-Encoding', 'User-Agent');

        return $this->engine->renderResponse('@CertificationyWeb/Site/footer.html.twig', [
            'trainings' => $this->certificationManager->getCertifications()
        ]);
    }
}
