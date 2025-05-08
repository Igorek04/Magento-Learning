<?php

namespace Perspective\HomeworkLowStockLabel\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Helper\Data as CatalogHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\CatalogInventory\Api\StockRegistryInterface;

class LowStockLabel implements ArgumentInterface
{
    /**
     * @var CatalogHelper
     */
    private CatalogHelper $catalogHelper;

    /**
     * @var ScopeConfigInterface 
     */
    private ScopeConfigInterface $scopeConfig;

    /**
     * @var StockRegistryInterface 
     */
    private StockRegistryInterface $stockRegistry;

    /**
     * Constructor
     *
     * @param CatalogHelper $catalogHelper
     * @param ScopeConfigInterface $scopeConfig
     * @param StockRegistryInterface $stockRegistry
     */
    public function __construct(
        CatalogHelper $catalogHelper,
        ScopeConfigInterface $scopeConfig,
        StockRegistryInterface $stockRegistry
    ) {
        $this->catalogHelper = $catalogHelper;
        $this->scopeConfig = $scopeConfig;
        $this->stockRegistry = $stockRegistry;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->isSetFlag(
            'homeworklowstocklabel/settings/enabled',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getLowStockLevel($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        return $this->scopeConfig->getValue(
            'homeworklowstocklabel/settings/stock_alert_level',
            $scope
        );
    }

    /**
     * @return string
     */
    public function getProductQty()
    {
        $product = $this->catalogHelper->getProduct();
        
        $stockItem = $this->stockRegistry->getStockItem($product->getId());

        return $stockItem->getQty();
    }
}
