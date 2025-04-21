<?php

namespace Perspective\TutorialProductPage\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/** Helper for Custom product templates */
class Custom extends AbstractHelper
{
    /** @var array  */
    private $_availableSku = [
        '24-MB03',
        'Mj01',
        'MJ02'
    ];

    /**
     * Validate template visualization for given product sku
     *
     * @param string $sku
     * @return bool
     */
    public function validateProductBySku($sku)
    {
        if (in_array($sku, $this->getValidSkuArray())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    protected function getValidSkuArray()
    {
        return $this->_availableSku;
    }
}