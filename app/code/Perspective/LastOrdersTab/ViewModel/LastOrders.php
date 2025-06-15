<?php

namespace Perspective\LastOrdersTab\ViewModel;

use Perspective\LastOrdersTab\Model\ResourceModel\LastOrder\CollectionFactory;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

class LastOrders implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    protected $lastOrderCollectionFactory;

    /**
     * @var CatalogHelper 
     */
    protected $catalogHelper;    

    /**
     * @var TimezoneInterface 
     */
    protected $timezone;
    
    /**
     * @param CollectionFactory $lastOrderCollectionFactory
     * @param CatalogHelper $catalogHelper
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        CollectionFactory $lastOrderCollectionFactory,
        CatalogHelper $catalogHelper,
        TimezoneInterface $timezone
        ) {
        $this->lastOrderCollectionFactory = $lastOrderCollectionFactory;
        $this->catalogHelper = $catalogHelper;
        $this->timezone = $timezone;
    }

    /**
     * Returns a collection of records with product ID and order date.
     *
     * @param int $productId
     * 
     * @return \Perspective\LastOrdersTab\Model\ResourceModel\LastOrder\Collection
     */
    public function getLastOrdersByProductId($productId)
    {
        $collection = $this->lastOrderCollectionFactory->create();
        $collection->addFieldToFilter('product_id', $productId);
        $collection->setOrder('order_date', 'DESC');
        
        return $collection;
    }

    /**
     * @return int
     */
    public function getCurrentProductId()
    {
        return $this->catalogHelper->getProduct()->getId();
    }

    /**
     * Converts UTC date to store timezone and formats it.
     * 
     * @param string $orderDate
     *
     * @return string
     */
    public function formatDate($orderDate)
    {
        return $this->timezone->date(new \DateTime($orderDate))->format('d.m.Y H:i:s');
    }
}