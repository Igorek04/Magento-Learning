<?php

namespace Perspective\RestrictAddToCart\Plugin\Model\Checkout\Cart;

use Magento\Framework\Exception\LocalizedException;
use Magento\Catalog\Model\Product;
use Magento\Checkout\Model\Cart;


class RestrictAddToCart
{
    /**
     * Before plugin for addProduct method in Cart.
     *
     * @param \Magento\Checkout\Model\Cart $subject
     * @param \Magento\Catalog\Model\Product $productInfo
     * @param mixed $requestInfo
     *
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function beforeAddProduct(Cart $subject, Product $productInfo, $requestInfo = null)
    {
        try {
            // restrict if price < 10
            $productId = $productInfo->getId();
            if ($productInfo->getFinalPrice() < 10) {
                throw new LocalizedException(__('Could not add Product to Cart with low price'));
            }
            
            // restrict if qty < 3
            $qty = $requestInfo['qty'];
            if ($qty < 3) {
                throw new LocalizedException(__('Could not add Product to Cart with low qty'));
            }

        } catch (\Exception $e) {
            throw new LocalizedException(__($e->getMessage()));
        }
        return [$productInfo, $requestInfo];
    }
}
