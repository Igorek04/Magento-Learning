<?php

namespace Perspective\PaymentTools\ViewModel;

use Magento\Payment\Api\PaymentMethodListInterface;
use Magento\Payment\Api\Data\PaymentMethodInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Store\Model\StoreManagerInterface;

class PaymentMethods implements ArgumentInterface
{
    /**
     * @var PaymentMethodListInterface
     */
    private $paymentMethodList;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * PaymentMethods constructor.
     *
     * @param PaymentMethodListInterface $paymentMethodList
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        PaymentMethodListInterface $paymentMethodList,
        StoreManagerInterface $storeManager
    ) {
        $this->paymentMethodList = $paymentMethodList;
        $this->storeManager = $storeManager;
    }

    /**
     * Get list of all payment methods for the current store.
     *
     * @return PaymentMethodInterface[]
     */
    public function getPaymentMethods(): array
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $this->paymentMethodList->getList($storeId);
    }
}