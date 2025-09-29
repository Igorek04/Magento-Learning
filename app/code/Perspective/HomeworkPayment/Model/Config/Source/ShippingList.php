<?php
namespace Perspective\HomeworkPayment\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Shipping\Model\Config as ShippingConfig;

class ShippingList implements OptionSourceInterface
{
    /**
     * @var ShippingConfig 
     */
    protected $shippingConfig;

    /**
     * @param ShippingConfig $shippingConfig
     */
    public function __construct(ShippingConfig $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    public function toOptionArray()
    {
        $options = [];

        $options[] = [
            'value' => 'all',          
            'label' => __('All Methods')
        ];

        $carriers = $this->shippingConfig->getAllCarriers();
        foreach ($carriers as $code => $carrierModel) {
            if ($carrierTitle = $carrierModel->getConfigData('title')) {
                $options[] = [
                    'value' => $code,
                    'label' => $carrierTitle
                ];
            }
        }
        return $options;
    }
}