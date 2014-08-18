<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Component\Certy\Model;

use JMS\Serializer\Annotation\Type;

class Timer
{
    /**
     * @var \DateTime
     * @Type("\DateTime")
     */
    protected $start;

    /**
     * @var \DateTime
     * @Type("\DateTime")
     */
    protected $stop;

    public function start()
    {
        $this->start = new \DateTime();
    }

    public function stop()
    {
        $this->stop = new \DateTime();
    }

    /**
     * @return integer[]
     */
    public function elapsed()
    {
        $diff =  $this->stop->diff($this->start);

        return [
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s
        ];
    }
}
