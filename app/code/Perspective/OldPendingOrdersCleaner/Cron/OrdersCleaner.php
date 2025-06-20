<?php

namespace Perspective\OldPendingOrdersCleaner\Cron;

use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Model\ResourceModel\Order as OrderResourceModel;

class OrdersCleaner
{
    /**
     * @var CollectionFactory
     */
    protected $orderCollectionFactory;

    /**
     * @var OrderResourceModel
     */
    protected $orderResourceModel;

    /**
     * @param CollectionFactory $orderCollectionFactory
     * @param OrderResourceModel $orderResourceModel
     */
    public function __construct(
        CollectionFactory $orderCollectionFactory,
        OrderResourceModel $orderResourceModel
        ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
        $this->orderResourceModel = $orderResourceModel;
    }

    /**
     * Cancel pending orders older than 7 days
     */
    public function execute()
    {
        // 7 days ago from now
        $sevenDaysAgo = date('Y-m-d H:i:s', strtotime('-7 days'));

        // Get pending orders older than 7 days
        $collection = $this->orderCollectionFactory->create()
            ->addFieldToFilter('status', 'pending')
            ->addFieldToFilter('created_at', ['lt' => $sevenDaysAgo]);

        // Count orders for canceling
        $canceledOrdersCount = $collection->getSize();
        
        // Cancel orders
        foreach ($collection as $order) {
            /** @var \Magento\Sales\Model\Order $order */
            $order->cancel();
            $this->orderResourceModel->save($order);
        }

        // Log result
        echo "[" . date('Y-m-d H:i:s') . "] " . "Old pending orders canceled (" . $canceledOrdersCount . ")." . "\n";
        return $this;
    }
}