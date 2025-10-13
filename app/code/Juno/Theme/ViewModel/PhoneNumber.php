<?php
declare(strict_types=1);

namespace Juno\Theme\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;

class PhoneNumber implements ArgumentInterface {
    public function __construct(
        private readonly ScopeConfigInterface $scopeConfig,
    ) {}

    public function getPhoneNumber(): string
    {
        return $this->scopeConfig->getValue('general/store_information/phone');
    }

    public function getStoreHours(): string
    {
        return $this->scopeConfig->getValue('general/store_information/hours');
    }
}
