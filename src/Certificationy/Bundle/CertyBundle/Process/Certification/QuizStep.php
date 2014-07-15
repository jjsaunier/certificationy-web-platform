<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Process\Certification;

use Sylius\Bundle\FlowBundle\Process\Context\ProcessContextInterface;
use Symfony\Component\HttpFoundation\Response;

class QuizStep extends CertificationControllerStep
{
    /**
     * @param ProcessContextInterface $context
     *
     * @return Response
     */
    public function displayAction(ProcessContextInterface $context)
    {
        $certificationHandler = $this->container->get('certy.certification.form_handler');
        $certificationHandler->setRequest($context->getRequest());

        if ($certification = $certificationHandler->process($this->certification)) {
            $context->getStorage()->set('certification', $certification);

            return $this->complete();
        }

        return $this->render('CertificationyCertyBundle:Certification/Step:QuizStep.html.twig', array(
            'certification' => $this->certification,
            'form' => $certificationHandler->createView()
        ));
    }
}
