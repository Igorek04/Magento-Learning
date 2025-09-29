<?php

namespace Perspective\HomeworkPayment\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryList implements OptionSourceInterface
{
    /**
     * @var CollectionFactory 
     */
    protected $categoryCollectionFactory;

    /**
     * @param CollectionFactory $categoryCollectionFactory
     */
    public function __construct(CollectionFactory $categoryCollectionFactory)
    {
        $this->categoryCollectionFactory = $categoryCollectionFactory;
    }

    /**
     * Return array of categories that contain at least one product
     * 
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->categoryCollectionFactory->create()
            ->addAttributeToSelect('name')
            ->addFieldToFilter('level', ['gt' => 1])
            ->addFieldToFilter('is_active', 1);

        $options = [];
        foreach ($collection as $category) {
            if ($category->getProductCount() > 0) {
                $options[] = [
                    'value' => $category->getId(),
                    'label' => $category->getName()
                ];
            }
        }
        return $options;
    }
}