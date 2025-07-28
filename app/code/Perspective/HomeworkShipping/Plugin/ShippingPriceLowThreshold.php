<?php

namespace Perspective\HomeworkShipping\Plugin;

class ShippingPriceLowThreshold
{
    /**
     * Set minimum shipping price — not less than 2.00.
     */
    public function afterCollectRates(
        \Perspective\HomeworkShipping\Model\Carrier\Shipping $subject,
        $result,
        \Magento\Quote\Model\Quote\Address\RateRequest $request
    ) {
        $rates = $result->getAllRates();

        if (!empty($rates) && isset($rates[0])) {
            $method = $rates[0];
            $shippingPrice = $method->getPrice();
            if ($shippingPrice <= 2) {
                $method->setPrice(2.00);
            }
        }
        return $result;
    }
}
