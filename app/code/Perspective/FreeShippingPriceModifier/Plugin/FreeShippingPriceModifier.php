<?php
namespace Perspective\FreeShippingPriceModifier\Plugin;

class FreeShippingPriceModifier
{
    /**
     * @var \Magento\Customer\Model\Session $customerSession 
     */
    protected $customerSession;

    /**
     * @param \Magento\Customer\Model\Session $customerSession
     */
    public function __construct(
        \Magento\Customer\Model\Session $customerSession,
    ) {
        $this->customerSession = $customerSession;
    }

    public function afterCollectRates(
        \Magento\OfflineShipping\Model\Carrier\Freeshipping $subject,
        $result,
        \Magento\Quote\Model\Quote\Address\RateRequest $request
    ) {
        if (!$this->customerSession->isLoggedIn()) {
            /** @var \Magento\Shipping\Model\Rate\Result $result */
            $rates = $result->getAllRates();

            if (isset($rates[0])) {
                $rates[0]->setPrice(1.00);
            }
        }
        return $result;
    }
}