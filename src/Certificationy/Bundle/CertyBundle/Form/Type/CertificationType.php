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

class CertificationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $certification = $options['certification'];

        foreach ($certification->getCategories() as $category) {
            foreach ($category->getQuestions() as $question) {
                $builder->add($question->getName(), 'certification_answer', ['question' => $question]);
            }
        }

        $builder->add('Submit', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setRequired(['certification']);

        $resolver->setAllowedTypes([
            'certification' => ['Certificationy\Component\Certy\Model\Certification']
        ]);

        $resolver->setDefaults([
            'data_class' => 'Certificationy\Component\Certy\Model\ResultCertification'
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certy_certification_default';
    }
}
