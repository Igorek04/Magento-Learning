<?php

namespace Perspective\HomeworkCurrencyConverter\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Directory\Model\CurrencyFactory;

class MagentoData extends AbstractHelper
{
    /**
     * @var CurrencyFactory
     */
    private CurrencyFactory $currencyFactory;

    /**
     * Constructor
     *
     * @param CurrencyFactory $currencyFactory
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        CurrencyFactory $currencyFactory,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->currencyFactory = $currencyFactory;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get Course from Magento Currency Rates
     * 
     * @param string $currencyCode
     * 
     * @return string
     */
    public function getMagentoCourse(
        $currencyCode,
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ) {
        $baseCurrencyCode = $this->scopeConfig->getValue(
            'currency/options/base', 
            $scope
        );
        $currencyModel = $this->currencyFactory->create()->load($baseCurrencyCode);

        return $currencyModel->getRate($currencyCode);
    }

    /**
     * @param string $currencyCode
     *
     * @return string
     */
    public function getCurrencySymbol($currencyCode)
    {
        $currency = $this->currencyFactory->create()->load($currencyCode);
        
        return $currency->getCurrencySymbol();
    }
}
