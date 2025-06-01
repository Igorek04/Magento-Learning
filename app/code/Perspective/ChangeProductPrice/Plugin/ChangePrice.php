<?php

namespace Perspective\ChangeProductPrice\Plugin;

use Perspective\ChangeProductPrice\Helper\Data;

class ChangePrice
{
    /**
     * @var Data 
     */
    protected $configHelper;

    /**
     * @param Data $configHelper
     */
    public function __construct(Data $configHelper)
    {
        $this->configHelper = $configHelper;
    }

    /**
     * After plugin for getPrice method.
     *
     * Applies a discount to the product price 
     * if the product belongs to one of the configured categories
     * and the module is enabled.
     *
     * @param \Magento\Catalog\Model\Product
     * @param float $result Original product price
     * @return float Modified product price
     */
    public function afterGetPrice(\Magento\Catalog\Model\Product $subject, $result)
    {
        if (!$this->configHelper->isModuleEnabled()) {
            return $result;
        }

        $configCategoryIds = $this->configHelper->getSelectedCategoryIds();

        $productCategoryIds = $subject->getCategoryIds();

        foreach ($productCategoryIds as $categoryId) {
            if (in_array($categoryId, $configCategoryIds)) {

                $discountRate = $this->configHelper->getDiscountRate();
                $discount = $result * ((float)$discountRate / 100);
                return $result - $discount;
            }
        }
        return $result;
    }
}
