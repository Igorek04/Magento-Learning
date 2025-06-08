<?php

namespace Perspective\CurrencyRateModifier\Plugin;

class CurrencyRateModifier
{ 
    public function afterGetRate(\Magento\Directory\Model\Currency $subject, $rate)
    {
        if ($rate) {
            return $rate * 1.10;
        }
        return $rate;
    }
}