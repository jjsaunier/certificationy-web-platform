<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Twig\Extension;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

class TrainingExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Bundle\FrameworkBundle\Translation\Translator
     */
    protected $translator;

    /**
     * @param Translator $translator
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('elapsed', array($this, 'elapsed'))
        );
    }

    /**
     * @param array $elapsed
     */
    public function elapsed(Array $elapsed)
    {
        $strings = array(
            'h' => 'time.hour',
            'i' => 'time.minute',
            's' => 'time.second'
        );

        $output = array();

        foreach ($elapsed as $type => $value) {
            if ($value !== 0) {
                $output[] = $value.$this->translator->trans($strings[$type], array(), 'report');
            }
        }

        return implode(' ', $output);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'training_extension';
    }
}
