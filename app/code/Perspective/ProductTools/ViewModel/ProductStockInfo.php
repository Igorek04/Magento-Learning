<?php
namespace Perspective\ProductTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * ViewModel for retrieving product stock information.
 */
class ProductStockInfo implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var StockRegistryInterface
     */
    protected StockRegistryInterface $stockRegistry;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        StockRegistryInterface $stockRegistry
    ) {
        $this->productRepository = $productRepository;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * Get product by ID.
     *
     * @param int $productId
     * @return ProductInterface
     */
    public function getProductById($productId): ProductInterface
    {
        return $this->productRepository->getById($productId);
    }

    /**
     * Get stock information for a product.
     *
     * @param ProductInterface $product
     * @return array
     */
    public function getStockInformation(ProductInterface $product): array
    {
        $stockItem = $this->stockRegistry->getStockItem($product->getId());

        return [
            'qty' => $stockItem->getQty(),
            'min_qty' => $stockItem->getMinQty(),
            'min_sale_qty' => $stockItem->getMinSaleQty(),
            'max_sale_qty' => $stockItem->getMaxSaleQty(),
            'is_in_stock' => $stockItem->getIsInStock() ? 'Yes' : 'No',
        ];
    }
}
