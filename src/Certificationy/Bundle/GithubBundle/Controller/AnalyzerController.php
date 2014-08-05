<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\GithubBundle;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AnalyzerController extends Controller
{
    /**
     * @param Request $request
     */
    public function analyzeAction(Request $request)
    {
        $analyzerManager = $this->container->get('certificationy.github_analyser.manager');


    }
} 