<?php

namespace Perspective\TutorialProductPage\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Perspective\TutorialProductPage\Helper\Custom as CustomHelper;

class Custom implements ArgumentInterface
{
    /**
    * @var ProductRepositoryInterface
    */
    private $productRepository;

    /**
    * @var CustomHelper
    */
    private $customHelper;

    /**
     * Constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param CustomHelper $customHelper
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CustomHelper $customHelper
    ) {
        $this->productRepository = $productRepository;
        $this->customHelper = $customHelper;
    }
    
    /**
    * Return final price text for a product by ID.
    *
    * @param int $productId
    * @return string
    */
    public function getAnyCustomValue($productId)
    {
        $currentProduct = $this->productRepository->getById($productId);
        $customValue = "Final price: ";
        return $customValue . $currentProduct->getFinalPrice();
    }

    /**
    * Check if the custom block should be displayed for the current product.
    *
    * @param int $productId
    * @return bool
    */
    public function isAvailable($productId)
    {
        $currentProduct = $this->productRepository->getById($productId);
        return $this->customHelper->validateProductBySku($currentProduct->getSku());
    }

}
