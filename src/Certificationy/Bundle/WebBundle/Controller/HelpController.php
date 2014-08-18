<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\WebBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class HelpController extends AbstractController
{
    /**
     * @param Request $request
     */
    public function showAction(Request $request)
    {
        return $this->engine->renderResponse('@CertificationyWeb/Help/show.html.twig');
    }
}
