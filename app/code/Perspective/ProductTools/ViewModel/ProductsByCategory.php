<?php
namespace Perspective\ProductTools\ViewModel;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class ProductsByCategory implements ArgumentInterface
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
     * ProductsByCategory constructor.
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

    public function getCategoryById(int $categoryId)
    {
        return $this->categoryRepository->get($categoryId);
    }

    /**
     * Get products by category ID.
     *
     * @param int $categoryId
     * @return \Magento\Catalog\Model\ResourceModel\Product\Collection
     */
    public function getProductsByCategoryId(int $categoryId)
    {
        // Get a collection of products by category
        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addCategoryFilter($this->categoryRepository->get($categoryId));
        $productCollection->addAttributeToSelect(['name']);
        
        return $productCollection;
    }
}