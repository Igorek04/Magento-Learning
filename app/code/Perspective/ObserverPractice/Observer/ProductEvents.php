<?php

namespace Perspective\ObserverPractice\Observer;

class ProductEvents implements \Magento\Framework\Event\ObserverInterface
{
    public function __construct() {}

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        //$myEventData = $observer->getData('myEventData');
        $product = $observer->getProduct();
        
        $originalName = $product->getName();
        $modifiedName = $originalName . ' - Content added by Perspective ';
        $product->setName($modifiedName);
    }
}
