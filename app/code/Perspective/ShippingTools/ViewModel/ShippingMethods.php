<?php

namespace Perspective\ShippingTools\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Shipping\Model\Config;

class ShippingMethods implements ArgumentInterface
{
    /**
     * @var Config
     */
    private $shippingConfig;

    /**
     * ShippingMethods constructor.
     *
     * @param Config $shippingConfig
     */
    public function __construct(Config $shippingConfig) 
    {
        $this->shippingConfig = $shippingConfig;
    }

    /**
     * Get active shipping methods.
     *
     * @return array
     */
    public function getActiveShippingMethods()
    {
        $carriers = $this->shippingConfig->getActiveCarriers();
        $activeMethods = [];

        foreach ($carriers as $carrierCode => $carrierModel) 
        {
            $title = $carrierModel->getConfigData('title');
            $activeMethods[] = 
            [
                'code' => $carrierCode,
                'title' => $title
            ];
        }
        return $activeMethods;
    }
}