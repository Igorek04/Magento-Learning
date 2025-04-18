<?php

namespace Perspective\ProductTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Api\CategoryRepositoryInterface;

class FilteredProducts implements ArgumentInterface
{
    /**
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository;
    
    /**
     * @var CollectionFactory
     */
    protected $productCollectionFactory;

    /**
     * ProductFilter constructor.
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
     * Get a collection of products filtered by category and price
     *
     * @param int $categoryId 
     * @param float $priceMin
     * @param float $priceMax
     * 
     * @return Collection
     */
    public function getFilteredProducts($categoryId, $priceMin, $priceMax)
    {
        /** @var Collection $productCollection */
        $productCollection = $this->productCollectionFactory->create();
        
        // Category filter
        $productCollection->addCategoriesFilter(['in' => [$categoryId]]);

        // Price filter
        $productCollection->addAttributeToFilter('price', ['gteq' => $priceMin]);
        $productCollection->addAttributeToFilter('price', ['lteq' => $priceMax]);

        $productCollection->addAttributeToSelect(['name', 'price', 'sku']);
        return $productCollection;
    }
}