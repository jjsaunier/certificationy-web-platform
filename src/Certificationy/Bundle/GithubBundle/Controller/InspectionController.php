<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class InspectionController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inspectionWallAction(Request $request)
    {
        $dm = $this->container->get('doctrine_mongodb.odm.document_manager');
        $inspectionRepository = $dm->getRepository('CertificationyGithubBundle:InspectionReport');

        $inspections = $inspectionRepository->getLastInspection(15);

        return $this->render('CertificationyGithubBundle::inspection_wall.html.twig', array(
            'inspections' => $inspections
        ));
    }

    /**
     * @param Request $request
     * @param        string $checksum
     */
    public function inspectionCommitAction(Request $request, $checksum)
    {
        $dm = $this->container->get('doctrine_mongodb.odm.document_manager');
        $inspectionRepository = $dm->getRepository('CertificationyGithubBundle:InspectionReport');

        $inspection = $inspectionRepository->findOneByChecksum($checksum);

        if(null === $inspection){
            throw new HttpException(Response::HTTP_NOT_FOUND);
        }

        return $this->render('CertificationyGithubBundle::inspection_commit.html.twig', array(
            'inspection' => $inspection
        ));
    }
}
