<?php
namespace Perspective\HomeworkAirFreight\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Perspective\HomeworkAirFreight\Model\Attribute\Source\AirFreight as FreightSource;

class AirFreight implements ArgumentInterface
{
    /**
     * @var CatalogHelper
     */
    protected $catalogHelper;

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var array 
     */
    protected $config = null;

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var FreightSource
     */
    protected $freightSource;

    /**
     * @param CatalogHelper $catalogHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param PriceCurrencyInterface $priceCurrency
     * @param ProductRepositoryInterface $productRepository
     * @param FreightSource $freightSource
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        ScopeConfigInterface $scopeConfig,
        PriceCurrencyInterface $priceCurrency,
        ProductRepositoryInterface $productRepository,
        FreightSource $freightSource
    ) {
        $this->catalogHelper = $catalogHelper;
        $this->scopeConfig = $scopeConfig;
        $this->priceCurrency = $priceCurrency;
        $this->productRepository = $productRepository;
        $this->freightSource = $freightSource;
    }
    
    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * Get the current currency symbol.
     * 
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->priceCurrency->getCurrencySymbol();
    }

    /**
     * Retrieve module configuration array from store config.
     * 
     * @param ScopeConfigInterface $scope
     *
     * @return array
     */
    public function getConfigArray($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if ($this->config === null) {
            $this->config = $this->scopeConfig->getValue('homeworkAirFreight/settings', $scope);
        }
        return $this->config;
    }

    /**
     * Checks if the module is enabled in the configuration settings.
     *
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->getConfigArray()['enabled'];
    }

    /**
     * Get the current product type.
     * 
     * @return string
     */
    public function getProductType()
    {
        return $this->getCurrentProduct()->getTypeId();
    }

    /**
     * Get weight of a simple product.
     * 
     * @param  \Magento\Catalog\Model\Product $product
     * 
     * @return float
     */
    public function getSimpleWeight($product = null)
    {
        if ($product === null) {
            $product = $this->getCurrentProduct();
        }

        return $product->getWeight();
    }

    /**
     * Get average weight of simple products by parsing list of strings with IDs
     * 
     * @param  \Magento\Catalog\Model\Product $product
     * 
     * @return float|null
     */
    public function getConfigAverageWeight($product = null)
    {
        if ($product === null) {
            $product = $this->getCurrentProduct();
        }
        $simpleProductList = $product->getTypeInstance()->getUsedProducts($product);

        $simpleIds = [];
        foreach ($simpleProductList as $simpleProduct) {
            $simpleIds[] = (int) $simpleProduct->getId();
        }

        $totalWeight = 0;
        $count = count($simpleIds);

        foreach ($simpleIds as $id) {
            $loadedProduct = $this->productRepository->getById($id);
            $totalWeight += (float)$loadedProduct->getWeight();
        }

        if ($count > 0) {
            return $totalWeight / $count;
        } else {
            return 0;
        }

    }

    /**
     * Get product weight based on product type.
     *
     * Returns average weight for configurable products,
     * and simple weight for simple products.
     *
     * @return float|null
     */
    public function getWeight()
    {
        $productType = $this->getProductType();

        if ($productType === 'configurable') {
            return $this->getConfigAverageWeight();
        } elseif ($productType === 'simple') {
            return $this->getSimpleWeight();
        }
        return null;
    }

    /**
     * Get current air freight attribute value.
     * 
     * @return string
     */
    public function getAirFreightValue()
    {
        return $this->getCurrentProduct()->getData('air_freight_only');
    }

    /**
     * Get the label of the current air freight attribute value.
     * 
     * @return string
     */
    public function getAirFreightLabel()
    {
        $value = $this->getAirFreightValue();
        $options = $this->freightSource->getAllOptions();

        foreach ($options as $option) {
            if ($option['value'] === $value) {
                return $option['label'];
            }
        }
        return null;
    }

    /**
     * Returns config subset filtered by current air_freight_only attribute value.
     *
     * @return array
     */
    public function getCurrentFreightOptions()
    {
        $config = $this->getConfigArray();
        $attributeValue = $this->getAirFreightValue();
        $options = [];

        $needle = $attributeValue ?? '';
        foreach ($config as $key => $value) {
            if ($needle !== '' && strpos($key, $needle) !== false) {
                $options[$key] = $value;
            }
        }
        return $options;
    }

    /**
     * Check if product weight is over the configured weight limit.
     *
     * @return bool
     */
    public function isOverweighted(): bool
    {
        $options = $this->getCurrentFreightOptions();
        return $this->getWeight() > reset($options);
    }
    
    /**
     * Calculate the overweight fee based on product weight and config limits.
     *
     * @return float
     */
    public function getOverweightFee()
    {
        $options = $this->getCurrentFreightOptions();
        $weightLimit = reset($options);
        $overweightFee = next($options);
        $productWeight = $this->getWeight();

        $fee = 0;
        if ($this->isOverweighted()) {
            $fee = ($productWeight - $weightLimit) * $overweightFee;
        }
        return $fee;
    }
}