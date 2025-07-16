<?php
namespace Perspective\ProductPriceDetails\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Perspective\ProductPriceDetails\Helper\ConfigData as ConfigHelper;
use Magento\CatalogRule\Model\Rule;

class PriceDetails implements ArgumentInterface
{
    /**
     * @var CatalogHelper
     */
    protected $catalogHelper;

    /**
     * @var ConfigHelper
     */
    protected $configHelper;

    /**
     * @var Rule
     */
    protected $catalogRule;

    /**
     * @param CatalogHelper $catalogHelper
     * @param ConfigHelper $configHelper
     * @param Rule $catalogRule
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        ConfigHelper $configHelper,
        Rule $catalogRule
    ) {
        $this->catalogHelper = $catalogHelper;
        $this->configHelper = $configHelper;
        $this->catalogRule = $catalogRule;
    }

    /**
     * Format label (base_price -> Base Price).
     *
     * @param string $label
     *
     * @return string $label
     */
    protected function formatLabel(string $label)
    {
        return ucwords(str_replace('_', ' ', $label));
    }

     /**
     * Get array of visible prices enabled in config.
     *
     * @return array|null
     */
    public function getVisiblePrices()
    {
        if (!$this->configHelper->getConfigValue('enabled')) {
            return null;
        }

        $product = $this->catalogHelper->getProduct();
        $simpleProduct = $this->getFirstSimpleProduct($product);
        $basePrice = $simpleProduct->getPrice();

        $prices = [];
        $priceMap = [
            'base_price' => $basePrice,
            'final_price' => $product->getFinalPrice(),
            'special_price' => $product->getSpecialPrice(),
            'tier_price' => $this->getLastTierPrice($simpleProduct),
            'catalog_rule_price' => $this->catalogRule->calcProductPriceRule($simpleProduct, $basePrice)
        ];

        foreach ($priceMap as $price => $priceValue) {
            if ($this->configHelper->getConfigValue($price)) {
                $prices[] = [
                    'label' => $this->formatLabel($price),
                    'value' => $priceValue
                ];
            }
        }
        return $prices;
    }

    /**
     * Get last tier price if available.
     *
     * @param \Magento\Catalog\Model\Product $simpleProduct
     * 
     * @return float|null
     */
    public function getLastTierPrice($simpleProduct)
    {
        $tierPrices = $simpleProduct->getTierPrice();

        if (!empty($tierPrices)) {
            return end($tierPrices)['price'];
        }
        return null;
    }

    /**
     * Return first simple product for configurable, or original.
     *
     * @param \Magento\Catalog\Model\Product $product
     * 
     * @return \Magento\Catalog\Model\Product
     */
    public function getFirstSimpleProduct($product)
    {
        if ($product->getTypeId() === 'configurable') {
            return $product->getTypeInstance()->getUsedProducts($product)[0];
        }
        return $product;
    }
}
