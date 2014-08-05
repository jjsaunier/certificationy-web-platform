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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
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

        if (1 < count($context->getAvailableLanguages())) {
            $builder->add('language', 'choice', array('choices' => $context->getAvailableLanguages()));
        }

        if (null !== $context->getAvailableLevels()) {
            $builder->add('level', 'choice', array('choices' => $context->getAvailableLevels()));
        }

        if (true === $context->getAllowExcludeCategories()) {
            $builder->add('exclude_categories', 'certification_category', array(
                    'certification' => $options['certification'])
            );
        }

        if (true === $context->getAllowCustomNumberOfQuestions()) {
            $builder->add('number_of_questions', 'number');
        }

        $certification = $options['certification'];
        $metrics = $certification->getMetrics();

        if ($metrics->getQuestionCount() > 0 && $metrics->getAnswerCount() > 0) {
            $builder->add('submit', 'submit');
        }
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
            'data_class' => 'Certificationy\Component\Certy\Context\CertificationContext',
            'translation_domain' => 'form'
        ));
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        foreach ($view as $name => $child) {
            $child->vars['label'] = 'label.'.$name;
        }
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certy_certification_context';
    }
}
