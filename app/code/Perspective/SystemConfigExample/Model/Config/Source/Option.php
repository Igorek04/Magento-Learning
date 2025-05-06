<?php

namespace Perspective\SystemConfigExample\Model\Config\Source;

use Magento\Framework\Option\ArrayInterface;

class Option implements ArrayInterface
{
    public function toOptionArray()
    {
        return [
            ['value' => '1', 'label' => __('Option A')],
            ['value' => '2', 'label' => __('Option B')],
            ['value' => '3', 'label' => __('Option C')],
        ];
    }
}
