<?php
namespace Perspective\CustomerTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory;
use Magento\Customer\Model\ResourceModel\Customer\Collection;

/**
 * ViewModel for retrieving the customer collection.
 */
class CustomerCollection implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $customerCollectionFactory;

    /**
     * Constructor
     *
     * @param CollectionFactory $customerCollectionFactory
     */
    public function __construct(CollectionFactory $customerCollectionFactory)
    {
        $this->customerCollectionFactory = $customerCollectionFactory;
    }

    /**
     * Get customer collection with selected attributes.
     *
     * @return Collection
     */
    public function getCustomerCollection(): Collection
    {
        $collection = $this->customerCollectionFactory->create();
        $collection->addAttributeToSelect(['firstname', 'lastname', 'email']);
        return $collection;
    }
}
