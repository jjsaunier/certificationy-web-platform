<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Bundle\CertyBundle\Form\Type;

use Certificationy\Component\Certy\Calculator\Calculator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\ChoiceList\SimpleChoiceList;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AnswerType extends AbstractType
{
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'multiple' => true,
            'expanded' => true,
            'property_path' => 'results',
            'choice_list' => $this->getAnswersList()
        ));

        $resolver->setRequired(array(
            'question'
        ));

        $resolver->setAllowedTypes(array(
            'question' => array('Certificationy\Component\Certy\Model\Question')
        ));
    }

    /**
     * @return \Closure
     */
    public function getAnswersList()
    {
        return function (Options $options) {
            $question = $options->get('question');
            $choices = array();
            foreach ($question->getAnswers() as $answer) {
                $choices[Calculator::getHash($question->getCategory(), $question, $answer)] = $answer->getLabel();
            }

            return new SimpleChoiceList($choices);
        };
    }

    /**
     * @param FormView      $view
     * @param FormInterface $form
     * @param array         $options
     */
    public function finishView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label'] = $options['question']->getLabel();
    }

    /**
     * @return string
     */
    public function getParent()
    {
        return 'choice';
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'certification_answer';
    }
}
