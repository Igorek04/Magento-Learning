<?php
namespace Perspective\ProductTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Api\Data\ProductInterface;

/**
 * ViewModel for retrieving product image information.
 */
class ProductImage implements ArgumentInterface
{
    /**
     * @var ProductRepositoryInterface
     */
    protected ProductRepositoryInterface $productRepository;

    /**
     * @var ImageHelper
     */
    protected ImageHelper $imageHelper;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param ImageHelper $imageHelper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        ImageHelper $imageHelper
    ) {
        $this->productRepository = $productRepository;
        $this->imageHelper = $imageHelper;
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
     * Get product image info: URL, width, height.
     *
     * @param ProductInterface $product
     * @return array
     */
    public function getImageInfo(ProductInterface $product): array
    {
        // Initialize the product image with the specified type ('product_base_image').
        $image = $this->imageHelper->init($product, 'product_base_image');

        return [
            'url' => $image->getUrl(),
            'width' => $image->getWidth(),
            'height' => $image->getHeight()
        ];
    }
}