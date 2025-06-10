<?php

namespace Perspective\WareHousePreferenceModify\Model;

/**
 * Preference class that extends Post model from Perspective_DbWareHouse module
 * Adds method for calculating total product price in stock.
 */
class Post extends \Perspective\DbWareHouse\Model\Post
{
    /**
     * @return float
     */
    public function getProdsPrice()
    {
        $productId = $this->getData('id_prod');
        $productQty = $this->getData('kol_prod');

        /** @var \Magento\Catalog\Model\Product $product */
        $product = $this->productRepository->getById($productId);
        $productPrice = $product->getFinalPrice();
    
        return $productPrice * $productQty;
    }
}