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

class InspectionController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function inspectionWallAction(Request $request)
    {
        $dm = $this->container->get('doctrine_mongodb.odm.document_manager');
        $inspectionReportRepository = $dm->getRepository('CertificationyGithubBundle:InspectionReport');

        $inspections = $inspectionReportRepository->getLastInspection(15);

        return $this->render('CertificationyGithubBundle::inspection_wall.html.twig', array(
            'inspections' => $inspections
        ));
    }
}
