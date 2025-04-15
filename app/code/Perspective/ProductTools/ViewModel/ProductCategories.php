<?php
namespace Perspective\ProductTools\ViewModel;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Api\CategoryRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\Product;

class ProductCategories implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * ProductCategories constructor.
     * 
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get the product name by its ID
     *
     * @param int $productId
     * @return string
     */
    public function getProductNameById(int $productId): string
    {
        /** @var Product $product */
        $product = $this->productRepository->getById($productId);
        return $product->getName();
    }

    /**
     * Get categories of the product by its ID
     *
     * @param int $productId
     * @return array
     */
    public function getCategoryNamesByProductId(int $productId): array
    {
        /** @var Product $product */
        $product = $this->productRepository->getById($productId);
        $categoryIds = $product->getCategoryIds();

        $categoryNames = [];
        foreach ($categoryIds as $categoryId) {
            $category = $this->categoryRepository->get($categoryId);
            $categoryNames[] = $category->getName();
        }

        return $categoryNames;
    }
}