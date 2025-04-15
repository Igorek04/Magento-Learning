<?php

namespace Perspective\CatalogRuleTools\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogRule\Model\RuleFactory;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CatalogRuleProducts implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var RuleFactory
     */
    private $ruleFactory;

    /**
     * CatalogRuleProducts constructor.
     *
     * @param CollectionFactory $productCollectionFactory
     * @param RuleFactory $ruleFactory
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        RuleFactory $ruleFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->ruleFactory = $ruleFactory;
    }

    /**
     * Get products by catalog rule ID.
     *
     * @param int $ruleId
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductsByCatalogRuleId(int $ruleId)
    {
        /** @var \Magento\CatalogRule\Model\Rule $rule */
        $rule = $this->ruleFactory->create()->load($ruleId);
        $productIds = $rule->getMatchingProductIds();

        $collection = $this->productCollectionFactory->create();
        $collection->addIdFilter(array_keys($productIds));
        $collection->addAttributeToSelect(['name', 'price']);

        return $collection;
    }
}
