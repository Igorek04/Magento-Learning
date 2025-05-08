<?php

namespace Perspective\HomeworkCurrencyConverter\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class CustomData extends AbstractHelper
{
    /**
     * @return bool
     */
    public function isModuleEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworkcurrencyconverter/settings/enabled',
            $scope
        );
    }

    /**
     * @return bool
     */
    public function isUAHConverterEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworkcurrencyconverter/settings/uah_enable',
            $scope
        );
    }

    /**
     * @return bool
     */
    public function isRUBConverterEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworkcurrencyconverter/settings/rub_enable',
            $scope
        );
    }

    /**
     * @return bool
     */
    public function isEUROConverterEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworkcurrencyconverter/settings/euro_enable',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getCustomCourseUAH($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'homeworkcurrencyconverter/settings/uah_course',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getCustomCourseRUB($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'homeworkcurrencyconverter/settings/rub_course',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getCustomCourseEURO($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'homeworkcurrencyconverter/settings/euro_course',
            $scope
        );
    }
}
