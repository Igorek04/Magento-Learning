<?php

namespace Perspective\LastOrdersTab\Service;

use Perspective\LastOrdersTab\Model\LastOrderFactory;
use Perspective\LastOrdersTab\Model\ResourceModel\LastOrder\CollectionFactory;
use Perspective\LastOrdersTab\Model\ResourceModel\LastOrder as LastOrderResourceModel;

class LastProductSaver
{
    /**
     * @var LastOrderFactory
     */
    protected $lastOrderFactory;

    /**
     * @var CollectionFactory
     */
    protected $lastOrderCollectionFactory;

    /**
     * @var LastOrderResourceModel
     */
    protected $lastOrderResourceModel;

    /**
     * @param LastOrderFactory $lastOrderFactory
     * @param CollectionFactory $lastOrderCollectionFactory
     * @param LastOrderResourceModel $lastOrderResourceModel
     */
    public function __construct(
        LastOrderFactory $lastOrderFactory,
        CollectionFactory $lastOrderCollectionFactory,
        LastOrderResourceModel $lastOrderResourceModel
    ) {
        $this->lastOrderFactory = $lastOrderFactory;
        $this->lastOrderCollectionFactory = $lastOrderCollectionFactory;
        $this->lastOrderResourceModel = $lastOrderResourceModel;
    }

    /**
     * Adds a new order record for the given product.
     * If the number of saved records reaches the specified limit, the oldest one is removed.
     *
     * @param int $productId
     * @param string $orderDate
     * @param int $maxLastOrders
     */
    public function saveProductOrder($productId, $orderDate, $maxLastOrders)
    {
        // Load orders for this product
        $collection = $this->lastOrderCollectionFactory->create();
        $collection->addFieldToFilter('product_id', $productId);
        $collection->setOrder('order_date', 'ASC');

        // If too many records, delete the oldest
        if ($collection->getSize() >= $maxLastOrders) {
            $oldestProduct = $collection->getFirstItem();
            $oldestProduct->delete();
        }

        // Create and save a new record
        $lastOrder = $this->lastOrderFactory->create();
        $lastOrder->setData('product_id', $productId);
        $lastOrder->setData('order_date', $orderDate);
        $this->lastOrderResourceModel->save($lastOrder);
    }

    /**
     * Returns the configurable product ID if available
     * otherwise returns the simple product ID.
     *
     * @param \Magento\Sales\Model\Order\Item $product
     *
     * @return int
     */
    public function getCorrectProductId(\Magento\Sales\Model\Order\Item $product)
    {
        // Ignore configurable product to avoid duplicate entry
        if ($product->getProductType() === 'configurable') {
            return null;
        }

        // Get parent (configurable) product if available
        $parentProduct = $product->getParentItem();
        if ($parentProduct && $parentProduct->getProductType() === 'configurable') {
            return $parentProduct->getProductId();
        }

        // Use current simple product ID if no parent found
        return $product->getProductId(); 
    }
}
