<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CertyController extends Controller
{
    /**
     * @param Request $request
     */
    public function certificationAction(Request $request, $name)
    {
        $factory = $this->get('certy.certification.factory');

        $certification = $factory->createNamed($name);

        return $this->render('CertificationyCertyBundle:Certification:questions.html.twig', array(
            'certification' => $certification
        ));
    }
}
