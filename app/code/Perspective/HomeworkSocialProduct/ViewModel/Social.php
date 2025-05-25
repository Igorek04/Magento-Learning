<?php
namespace Perspective\HomeworkSocialProduct\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class Social implements ArgumentInterface
{
    /**
     * @var CatalogHelper
     */
    private $catalogHelper;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var PriceCurrencyInterface
     */
    private $priceCurrency;

    /**
     * @param CatalogHelper $catalogHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        ScopeConfigInterface $scopeConfig,
        PriceCurrencyInterface $priceCurrency,
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
     * @return \Magento\Catalog\Model\Product
     */
    public function getCurrentProduct()
    {
        return $this->catalogHelper->getProduct();
    }

    /**
     * @return bool
     */
    public function isSocialAttributeEnabled()
    {
        return $this->getCurrentProduct()->getData('is_social');
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