<?php

namespace Perspective\FinalPriceObserver\Observer;

class CheckoutPriceModifier implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * Runs on product final price event.
     * Increase product final price by 20%.
     * 
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Catalog\Model\Product $product */
        $product = $observer->getEvent()->getProduct();
        $finalPrice = $product->getData('final_price');

        $product->setFinalPrice($finalPrice * 1.2);
    }
}