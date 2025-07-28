<?php

namespace Perspective\ShippingMethodsVisibility\Plugin;

class ShippingMethodsVisibility
{
    public function afterEstimateByExtendedAddress($shippingMethodManagement, $output)
    {
        return $this->filterOutput($output);
    }

    private function filterOutput($output)
    {
        $free = [];
        foreach ($output as $shippingMethod) {
            if (
                $shippingMethod->getCarrierCode() == 'freeshipping' &&
                $shippingMethod->getMethodCode() == 'freeshipping'
            ) {
                $free[] = $shippingMethod;
            }
        }
        if ($free) {
            return $free;
        }
        return $output;
    }
}
