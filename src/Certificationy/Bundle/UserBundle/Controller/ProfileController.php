<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\UserBundle\Controller;

use FOS\UserBundle\Controller\ProfileController as BaseController;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

class ProfileController extends BaseController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException
     */
    public function showAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $reportRepository = $this->container
            ->get('doctrine.odm.mongodb.document_manager')
            ->getRepository('CertificationyTrainingBundle:Report')
        ;

        $paginator = $this->container->get('knp_paginator');

        $pagination = $paginator->paginate(
            $reportRepository->getQueryBuilderReportsForUser($user),
            $this->container->get('request')->query->get('page', 1),
            10
        );

        return $this->container->get('templating')->renderResponse(
            'FOSUserBundle:Profile:show.html.'.$this->container->getParameter('fos_user.template.engine'),
            array(
                'user' => $user,
                'pagination' => $pagination
            )
        );
    }
}
