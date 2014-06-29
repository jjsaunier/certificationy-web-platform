<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Controller;

use Certificationy\Bundle\WebBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class TrainingController extends AbstractController
{
    /**
     * @param Request $request
     */
    public function indexAction(Request $request)
    {
        $response = $this->engine->renderResponse('CertificationyTrainingBundle:Session:index.html.twig', array(

        ));

        return $response;
    }
} 