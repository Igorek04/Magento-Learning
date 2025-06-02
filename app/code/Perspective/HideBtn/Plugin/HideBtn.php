<?php

namespace Perspective\HideBtn\Plugin;

class HideBtn
{
    /**
     * Disable saleability for products with a final price less than 1.
     *
     * @param \Magento\Catalog\Model\Product $product
     * 
     * @return bool
     */
    public function afterIsSaleable(\Magento\Catalog\Model\Product $product)
    {
        if ($product->getFinalPrice() < 1) { 
            return false; // For hide button to products with price < 1

        } else {
            return true; // For display button
        }
    }
}
