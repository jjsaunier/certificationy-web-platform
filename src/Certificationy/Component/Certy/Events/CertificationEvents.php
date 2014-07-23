<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Events;

final class CertificationEvents
{
    const CERTIFICATION_SUBMISSION = 'certy.certification.submission';
    const CERTIFICATION_PRE_COMPUTATION = 'certy.certification.pre_computation';
    const CERTIFICATION_POST_COMPUTATION = 'certy.certification.post_computation';
    const CERTIFICATION_CUSTOM_CONTEXT = 'certy.certification.custom_context';
    const CERTIFICATION_START = 'certy.certification.start';
}
