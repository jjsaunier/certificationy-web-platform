<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class SiteController extends AbstractController
{
    public function indexAction(Request $request)
    {
        $response = $this->engine->renderResponse('@CertificationyWeb/Site/homepage.html.twig', array(

        ));

        return $response;
    }
}
