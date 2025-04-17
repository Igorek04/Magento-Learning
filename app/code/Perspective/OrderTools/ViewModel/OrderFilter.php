<?php

namespace Perspective\OrderTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Model\ResourceModel\Order\Collection;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class OrderFilter implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private $orderCollectionFactory;

    /**
     * OrderFilter constructor.
     *
     * @param CollectionFactory $orderCollectionFactory
     */
    public function __construct(
        CollectionFactory $orderCollectionFactory
    ) {
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    /**
     * Get filtered orders based on grand total.
     *
     * @param float $minPrice
     * @return Collection
     */
    public function getFilteredOrders(float $minPrice): Collection
    {
        $collection = $this->orderCollectionFactory->create();
        $collection->addFieldToFilter('grand_total', ['gteq' => $minPrice]);

        return $collection;
    }
}
