<?php
 /**
 * This file is part of the Certificationy web platform.
 * (c) Johann Saunier (johann_27@hotmail.fr)
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 **/

namespace Certificationy\Bundle\CertyBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContextType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $context = $options['data'];

        $builder->add('language', 'choice', array('choices' => $context->getAvailableLanguages()));

        $builder->add('level', 'choice', array(
            'choices' => $context->getAvailableLevels(),
            'attr' => array('help_text' => 'This is actually not implemented')
        ));

        $builder->add('exclude_categories', 'certification_category', array(
            'certification' => $options['certification'])
        );

        $builder->add('Submit', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(array(
            'certification'
        ));

        $resolver->setAllowedTypes(array(
            'certification' => array('Certificationy\Component\Certy\Model\Certification')
        ));

        $resolver->setDefaults(array(
            'data_class' => 'Certificationy\Component\Certy\Context\CertificationContext'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certy_certification_context';
    }
}
