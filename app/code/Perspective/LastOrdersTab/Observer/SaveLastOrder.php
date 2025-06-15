<?php

namespace Perspective\LastOrdersTab\Observer;

use Perspective\LastOrdersTab\Service\LastProductSaver;

class SaveLastOrder implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var LastProductSaver
     */
    protected $lastProductSaver;

    /**
     * @param LastProductSaver $lastProductSaver
     */
    public function __construct(LastProductSaver $lastProductSaver)
    {
        $this->lastProductSaver = $lastProductSaver;
    }

    /**
     * Runs on order save event.
     * Saves order date for each product in the order.
     *
     * @param \Magento\Framework\Event\Observer $observer
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var \Magento\Sales\Model\Order $order */
        $order = $observer->getEvent()->getOrder();
        
        // Current date and time
        $orderDate = date('Y-m-d H:i:s');

        // Get products visible in order 
        $products = $order->getAllVisibleItems();

        // Max number of saved last orders per product
        $maxLastOrders = 3;

        foreach ($products as $product) {
            $productId = $this->lastProductSaver->getCorrectProductId($product);
            
            $this->lastProductSaver->saveProductOrder($productId, $orderDate, $maxLastOrders);
        }
    }
}