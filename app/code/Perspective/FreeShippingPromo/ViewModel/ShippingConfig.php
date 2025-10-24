<?php
namespace Perspective\FreeShippingPromo\ViewModel;

use Magento\Framework\App\Config\ScopeConfigInterface;

class ShippingConfig implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
    ) {}

    public function getFreeShippingThreshold(): int
    {
        return (int) $this->scopeConfig->getValue('carriers/freeshipping/free_shipping_subtotal');
    }
}
