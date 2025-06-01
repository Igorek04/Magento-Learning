<?php

namespace Perspective\ChangeProductPrice\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class Data extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'practiceChangeProductPrice/settings/enabled',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getDiscountRate($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'practiceChangeProductPrice/settings/discount_rate',
            $scope
        );
    }

    /**
     * Get selected categories from admin-config
     * 
     * @return array
     */
    public function getSelectedCategoryIds($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        $value = $this->scopeConfig->getValue(
            'practiceChangeProductPrice/settings/category_select',
            $scope
        );

        if ($value) {
            return array_map('intval', explode(',', $value));
        }

        return [];
    }
}
