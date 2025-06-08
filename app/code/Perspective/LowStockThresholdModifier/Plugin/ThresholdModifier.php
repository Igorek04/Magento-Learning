<?php

namespace Perspective\LowStockThresholdModifier\Plugin;

use Magento\InventorySales\Model\GetProductSalableQty;
use Magento\CatalogInventory\Model\Configuration;

class ThresholdModifier
{
    /**
     * @var Configuration 
     */
    protected $catalogInventoryConfig;

    /**
     * @param Configuration $catalogInventoryConfig
     */
    public function __construct(Configuration $catalogInventoryConfig)
    {
        $this->catalogInventoryConfig = $catalogInventoryConfig;
    }

    /**
     * Modify salable quantity after retrieval.
     * Returns half the quantity rounded up if it is less or equal to minQty.
     * Returns 0 if original quantity is 0.
     *
     * @param GetProductSalableQty $subject
     * @param float $result
     * @param string $sku
     * @param int $stockId
     *
     * @return float
     */
    public function afterExecute(GetProductSalableQty $subject, float $result, string $sku, int $stockId): float
    {
        if ($result == 0) {
            return 0;
        }

        //check if function used in the required block (block on product page(Only X left))
        if (strpos((new \Exception())->getTraceAsString(), 'Magento\CatalogInventory\Block\Stockqty\DefaultStockqty') === false) {
            return $result;
        }

        //value from config
        $threshold = $this->catalogInventoryConfig->getStockThresholdQty();

        if ($result <= $threshold) {
            return (float) ceil($result / 2);
        }

        return $result;
    }
}