<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\TrainingBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

class TrainingExtension extends \Twig_Extension
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter('elapsed', [$this, 'elapsed'])
        ];
    }

    /**
     * @param array $elapsed
     *
     * @return string
     */
    public function elapsed(array $elapsed)
    {
        $strings = [
            'h' => 'time.hour',
            'i' => 'time.minute',
            's' => 'time.second'
        ];

        $output = [];

        foreach ($elapsed as $type => $value) {
            if ($value !== 0) {
                $output[] = $value.$this->translator->trans($strings[$type], [], 'report');
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
