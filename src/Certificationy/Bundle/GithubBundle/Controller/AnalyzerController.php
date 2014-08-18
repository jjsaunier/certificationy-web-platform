<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\GithubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnalyzerController extends Controller
{
    /**
     * @param Request $request
     *
     * CAUTION: THIS IS EXPERIMENTAL (and a success)
     * This controller will be explode.
     */
    public function analyzeAction(Request $request)
    {
        $reviewerBot = $this->container->get('github.reviewer.bot');

        return $reviewerBot->handle($request);
    }
}
