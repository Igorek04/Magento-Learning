<?php

namespace Perspective\ClothingMaterial\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;

class RelatedModel implements ArgumentInterface
{
    /**
     * @var CatalogHelper 
     */
    private CatalogHelper $catalogHelper;

    /**
     * @param CatalogHelper $catalogHelper
     */
    public function __construct(CatalogHelper $catalogHelper)
    {
        $this->catalogHelper = $catalogHelper;
    }

    /**
    * @return \Magento\Catalog\Model\Product|null
    */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }
}
