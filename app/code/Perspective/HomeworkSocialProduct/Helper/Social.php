<?php
namespace Perspective\HomeworkSocialProduct\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Social extends AbstractHelper
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
     * @param CatalogHelper $catalogHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        ScopeConfigInterface $scopeConfig,
        PriceCurrencyInterface $priceCurrency
    ) {
        $this->catalogHelper = $catalogHelper;
        $this->scopeConfig = $scopeConfig;
        $this->priceCurrency = $priceCurrency;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworkSocialProduct/settings/enabled',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getSocialDiscountRate($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'homeworkSocialProduct/settings/social_discount_rate',
            $scope
        );
    }
    
    /**
     * @return \Magento\Catalog\Model\Product|null
     */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * @return bool
     */
    public function isSocialAttributeEnabled(\Magento\Catalog\Model\Product $product = null)
    {
        if ($product === null) {
            $product = $this->getCurrentProduct();
        }

        return (bool) $product->getData('is_social');
    }

    /**
     * @return string
     */
    public function getSocialPrice()
    {
        return $this->getCurrentProduct()->getFinalPrice() * (1 - $this->getSocialDiscountRate() / 100);
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->priceCurrency->getCurrencySymbol();
    }
}