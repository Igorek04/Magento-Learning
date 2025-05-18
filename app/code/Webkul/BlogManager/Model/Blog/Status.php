<?php

namespace Webkul\BlogManager\Model\Blog;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    public function toOptionArray()
    {
        $options = [];
        $options[] = ['label' => 'Disabled', 'value' => 0];
        $options[] = ['label' => 'Enabled', 'value' => 1];
        return $options;
    }
}
