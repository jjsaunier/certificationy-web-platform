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
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'multiple' => true,
            'expanded' => true,
            'choice_list' => $this->getCategoryList()
        ]);

        $resolver->setRequired([
            'certification'
        ]);

        $resolver->setAllowedTypes([
            'certification' => ['Certificationy\Component\Certy\Model\Certification']
        ]);
    }

    /**
     * @return \Closure
     */
    protected function getCategoryList()
    {
        return function (Options $options) {
            $categoryBuffer = [];

            foreach ($options->get('certification')->getCategories() as $category) {
                $categoryBuffer[$category->getName()] = $category->getLabel();
            }

            return new SimpleChoiceList($categoryBuffer);
        };
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certification_category';
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }
}
