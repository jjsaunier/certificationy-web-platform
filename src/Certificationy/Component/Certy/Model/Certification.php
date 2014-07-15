<?php
/**
* This file is part of the PhpStorm.
* (c) johann (johann_27@hotmail.fr)
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
**/

namespace Certificationy\Component\Certy\Model;

use Certificationy\Component\Certy\Context\CertificationContext;
use Certificationy\Component\Certy\Context\CertificationContextInterface;
use JMS\Serializer\Annotation\Type;

class Certification
{
    /**
     * @var ModelCollection
     * @Type("ModelCollection<Certificationy\Component\Certy\Model\Category>")
     */
    protected $categories;

    /**
     * @var Metrics
     * @Type("Certificationy\Component\Certy\Model\Metrics")
     */
    protected $metrics;

    /**
     * @var CertificationContext
     * @Type("Certificationy\Component\Certy\Context\CertificationContext")
     */
    protected $context;

    /**
     * @var ResultCertification
     * @Type("Certificationy\Component\Certy\Model\ResultCertification")
     */
    protected $result;

    public function __construct()
    {
        $this->categories = new ModelCollection();
        $this->metrics = new Metrics();
    }

    /**
     * @param \Certificationy\Component\Certy\Model\ResultCertification $rawResult
     */
    public function setResult(ResultCertification $result = null)
    {
        $this->result = $result;
    }

    /**
     * @return \Certificationy\Component\Certy\Model\ResultCertification
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param \Certificationy\Component\Certy\Context\CertificationContext $context
     */
    public function setContext(CertificationContextInterface $context)
    {
        $this->context = $context;
    }

    /**
     * @return \Certificationy\Component\Certy\Context\CertificationContext
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
     * @return Metrics
     */
    public function getMetrics()
    {
        return $this->metrics;
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
     * @param Metrics $metrics
     */
    public function setMetrics(Metrics $metrics)
    {
        $this->metrics = $metrics;
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
        $certification->setMetrics($data['metrics']);

        return $certification;
    }
}
