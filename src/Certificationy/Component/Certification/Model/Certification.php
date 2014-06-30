<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certification\Model;

class Certification
{
    /**
     * @var ModelCollection
     */
    protected $categories;

    public function __construct()
    {
        $this->categories = new ModelCollection();
    }

    /**
     * @param Category $category
     */
    public function addCategory(Category $category)
    {
        if(null === $category->getCertification()){
            $category->setCertification($this);
        }

        $this->categories->add($category);
    }

    /**
     * @param ModelCollection $categories
     */
    public function setCategory(ModelCollection $categories)
    {
        foreach($categories as $category){
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
}