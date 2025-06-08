<?php

namespace Perspective\ProductPageSkuModifier\Plugin;

use Magento\Framework\App\Request\Http;

class SkuModifier
{
    /**
     * @var Http 
     */
    private $request;

    /**
     * @param Http $request
     */
    public function __construct(Http $request)
    {
        $this->request = $request;
    }

    /**
     * Modify SKU output only on product page 
     * and when called from the specific block(sku-display).
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param string $sku
     *
     * @return string
     */
    public function afterGetSku(\Magento\Catalog\Model\Product $product, $sku)
    {
        // check if current page - product page
        if ($this->request->getFullActionName() !== 'catalog_product_view') {
            return $sku;
        }

        //check if function used in the required block (block on product page for display sku)
        if (strpos((new \Exception())->getTraceAsString(), 'Magento\Catalog\Block\Product\View\Description') === false) {
            return $sku;
        }

        $id = $product->getId();
        return $id . " - " . $sku;
    }
}