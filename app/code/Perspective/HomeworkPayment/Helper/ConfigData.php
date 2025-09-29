<?php
namespace Perspective\HomeworkPayment\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigData extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Get shipping method allowed for this payment method
     * 
     * @return string
     */
    public function getAllowedShipping($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'payment/mypay/apply_shipping_method',
            $scope
        );
    }

    /**
     * Get list of allowed category ids for this payment method
     * 
     * @return array
     */
    public function getAllowedCategories($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        $allowedCategories = $this->scopeConfig->getValue(
            'payment/mypay/apply_categories',
            $scope
        );

        if (!$allowedCategories) {
            return [];
        }
        return array_map('intval', explode(',', $allowedCategories));
    }
}