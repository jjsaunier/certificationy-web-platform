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
use Certificationy\Bundle\UserBundle\Repository\UserRepository;
use Predis\Client;
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
     * @var UserRepository
     */
    protected $userRepository;

    /** @var  Client */
    protected $redisClient;

    /**
     * @param string               $rootDir
     * @param CertificationManager $certificationManager
     * @param UserRepository       $userRepository
     * @param Client               $redisClient
     */
    public function __construct(
        $rootDir,
        CertificationManager $certificationManager,
        UserRepository $userRepository,
        Client $redisClient
    ) {
        $this->kernelRootDir = $rootDir;
        $this->certificationManager = $certificationManager;
        $this->userRepository = $userRepository;
        $this->redisClient = $redisClient;
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $certificationCounter = [];

        foreach($this->certificationManager->getCertifications() as $cn => $label){
            $certificationCounter[$cn] = [
                'metrics' => (int) $this->redisClient->get($cn),
                'label' => $label,
                'icon' => $this->certificationManager->getContext($cn)->getIcons()
            ];
        }

        $response = $this->engine->renderResponse('@CertificationyWeb/Site/homepage.html.twig', [
            'count_members' => (int) $this->userRepository->countMembers(),
            'certification_done' => (int) $this->redisClient->get('total'),
            'certification_counters' => $certificationCounter
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
