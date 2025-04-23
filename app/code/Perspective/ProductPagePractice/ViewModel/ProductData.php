<?php

namespace Perspective\ProductPagePractice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;

class ProductData implements ArgumentInterface
{
    /**
    * @var CatalogHelper
    */
    private $catalogHelper;

    /**
     * Constructor.
     *
     * @param CatalogHelper $catalogHelper
     */
    public function __construct(
        CatalogHelper $catalogHelper
    ) {
        $this->catalogHelper = $catalogHelper;
    }
    
    /**
    * Get the current product from registry.
    *
    * @return \Magento\Catalog\Model\Product|null
    */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * Return current product category from registry.
     *
     * @return \Magento\Catalog\Model\Category|null
     */
    public function getCurrentCategory()
    {
        return $this->catalogHelper->getCategory();
    }
}
