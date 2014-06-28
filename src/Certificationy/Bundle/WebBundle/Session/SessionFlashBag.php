<?php
/**
 * This file is part of the Certificationy Web Platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\WebBundle\Session;

use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class SessionFlashBag extends FlashBag
{
    /**
     * @param string $message
     */
    public function alert($message)
    {
        $this->add('alert', $message);
    }

    /**
     * @param string $message
     */
    public function error($message)
    {
        $this->add('error', $message);
    }

    /**
     * @param string $message
     */
    public function info($message)
    {
        $this->add('info', $message);
    }

    /**
     * @param string $message
     */
    public function success($message)
    {
        $this->add('success', $message);
    }
}
