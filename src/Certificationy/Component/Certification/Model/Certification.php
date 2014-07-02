<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Model;

use Certificationy\Component\Certification\Context\CertificationContext;

class Certification
{
    /**
     * @var ModelCollection
     */
    protected $categories;

    /**
     * @var CertificationContext
     */
    protected $context;

    public function __construct()
    {
        $this->categories = new ModelCollection();
    }

    /**
     * @param \Certificationy\Component\Certification\Context\CertificationContext $context
     */
    public function setContext(CertificationContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return \Certificationy\Component\Certification\Context\CertificationContext
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if (null === $category->getCertification()) {
            $category->setCertification($this);
        }

        $this->categories->add($category);
    }

    /**
     * @param ModelCollection $categories
     */
    public function setCategories(ModelCollection $categories)
    {
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * @return ModelCollection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @param array $data
     *
     * @return Certification
     */
    public static function __set_state(Array $data)
    {
        $certification = new Certification();
        $certification->setCategories($data['categories']);
        $certification->setContext($data['context']);

        return $certification;
    }
}
