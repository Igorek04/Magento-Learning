<?php
namespace Perspective\ProductTools\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * ViewModel for retrieving products filtered by visibility.
 */
class ProductsByVisibility implements ArgumentInterface
{
    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * Constructor.
     *
     * @param CollectionFactory $productCollectionFactory
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        CollectionFactory $productCollectionFactory,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get product collection filtered by visibility.
     *
     * @param int $visibilityLevel
     * @return Collection
     */
    public function getProductsByVisibility(int $visibilityLevel): Collection
    {
        $collection = $this->productCollectionFactory->create();
        $collection->addAttributeToFilter('visibility', ['eq' => $visibilityLevel]);
        $collection->addAttributeToSelect(['name']);
        
        return $collection;
    }
}