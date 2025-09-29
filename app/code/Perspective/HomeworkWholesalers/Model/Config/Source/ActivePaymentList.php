<?php
namespace Perspective\HomeworkWholesalers\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Payment\Model\Config;

class ActivePaymentList implements OptionSourceInterface
{
    /**
     * @var Config
     */
    protected $paymentConfig;

    /**
     * @param Config $paymentConfig
     */
    public function __construct(Config $paymentConfig)
    {
        $this->paymentConfig = $paymentConfig;
    }

    /**
     * Get list of active payment methods
     *
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $methods = $this->paymentConfig->getActiveMethods();

        foreach ($methods as $code => $method) {
            $title = $method->getTitle();
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
