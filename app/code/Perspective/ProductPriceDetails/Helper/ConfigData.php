<?php

namespace Perspective\ProductPriceDetails\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;

class ConfigData extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface 
     */
    protected $scopeConfig;

    /**
     * @var array 
     */
    protected $config = null;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }
    
    /**
     * Get module configuration array from config.
     * 
     * @param ScopeConfigInterface $scope
     *
     * @return array
     */
    public function getConfigArray($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if ($this->config === null) {
            $this->config = $this->scopeConfig->getValue('productPriceDetails/settings', $scope);
        }
        return $this->config;
    }

    /**
     * Get config value by key.
     *
     * @param string $optionName
     * 
     * @return mixed|null
     */
    public function getConfigValue(string $optionName)
    {
        $config = $this->getConfigArray();
        return $config[$optionName];
    }
}


