<?php
namespace Perspective\HolidayDiscounts\Plugin;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Block\Product\AbstractProduct;
use Perspective\HolidayDiscounts\Helper\Validation as ValidationHelper;

class AddCatalogHolidayLabel
{
    /**
     * @var ValidationHelper 
     */
    protected $validationHelper;

    /**
     * @param ValidationHelper $validationHelper
     */
    public function __construct(
        ValidationHelper $validationHelper,
        ) {
        $this->validationHelper = $validationHelper;
    }

    /**
     * Add label to product card in catalog when holiday discount is active.
     *
     * @param AbstractProduct $subject
     * @param string $result
     * @param Product $product
     * 
     * @return string
     */
    public function afterGetProductDetailsHtml(AbstractProduct $subject, $result, Product $product)
    {
        if ($this->validationHelper->isActiveHolidayProduct($product)) {
            $customHtml = '<div style="background:#fff3cd; text-align:center; font-weight:bold;">
                            HOLIDAY DISCOUNT
                            </div>';
            return $result . $customHtml;
        } else {
            return $result;
        }
    }
}
