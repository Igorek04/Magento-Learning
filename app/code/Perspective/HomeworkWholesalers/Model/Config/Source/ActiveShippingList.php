<?php
namespace Perspective\HomeworkWholesalers\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Shipping\Model\Config;

class ActiveShippingList implements OptionSourceInterface
{
    /**
     * @var Config
     */
    protected $shippingConfig;

    /**
     * @param Config $shippingConfig
     */
    public function __construct(Config $shippingConfig)
    {
        $this->shippingConfig = $shippingConfig;
    }

    /**
     * Get list of active shipping methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $carriers = $this->shippingConfig->getActiveCarriers();

        foreach ($carriers as $code => $carrierModel) {
            $title = $carrierModel->getConfigData('title');
            if ($title) {
                $options[] = [
                    'value' => $code,
                    'label' => $title
                ];
            }
        }
        return $options;
    }
}
