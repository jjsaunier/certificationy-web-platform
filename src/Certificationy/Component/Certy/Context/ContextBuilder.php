<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Context;

class ContextBuilder implements ContextBuilderInterface
{
    /**
     * @var bool
     */
    protected $debug;

    /**
     * @param $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @param array $conf
     *
     * @return CertificationContext
     */
    public function build(array $conf)
    {
        $context = new CertificationContext($conf['name']);
        $context->setLabel($conf['label']);
        $context->setAvailableLanguages($conf['availableLanguages']);
        $context->setLanguage($conf['defaults']['language']);
        $context->setNumberOfQuestions($conf['defaults']['questions_peer_category']);
        $context->setAllowCustomNumberOfQuestions($conf['customize']['number_of_questions']);
        $context->setDebug($this->debug);

        $context->setAllowExcludeCategories($conf['customize']['exclude_categories']);

        if (null !== $availableContext = $conf['availableLevels']) {
            $context->setAvailableLevels($availableContext);
            $context->setLevel($conf['defaults']['level']);
        }

        if (null !== $conf['threshold']) {
            $context->setThreshold($conf['threshold']);
        }

        if (null !== $conf['icons']) {
            $context->setIcons($conf['icons']);
        }

        return $context;
    }
}
