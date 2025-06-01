<?php

namespace Perspective\DemoPluginBefore\Plugins\Catalog\Model;

class Product
{
    public function beforeSetName(\Magento\Catalog\Model\Product $product, $name)
    {
        return ['(' . $name . ')'];
    }
}
