<?php
namespace Perspective\ProductPriceDetails\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class EnabledDisabled implements ArrayInterface
{
    /**
     * Return array of available status options.
     *
     * @return array[]
     */
    public function toOptionArray()
    {
        return [
            ['value' => 1, 'label' => __('Enabled')],
            ['value' => 0, 'label' => __('Disabled')],
        ];
    }
}