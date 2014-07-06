<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\TrainingBundle\Certification;

use Certificationy\Component\Certy\Context\CertificationContext;

class SymfonyCertificationContext extends CertificationContext
{
    protected function initialized()
    {
        $this->setNumberOfQuestions(100);
        $this->setScore(50);
        $this->setLanguage('en');
        $this->setThreshold(array(
            array('newbie' => 30),
            array('beginner' => 45),
            array('not_bad' => 50),
            array('good' => 75),
            array('very_good' => 85),
            array('expert' => 95),
            array('jesus_christ' => 100)
        ));
    }
}
