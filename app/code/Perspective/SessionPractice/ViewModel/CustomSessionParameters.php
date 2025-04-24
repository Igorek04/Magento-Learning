<?php

namespace Perspective\SessionPractice\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Catalog\Model\Session as CatalogSession;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Checkout\Model\Session as CheckoutSession;

class CustomSessionParameters implements ArgumentInterface
{
    /**
    * @var CatalogSession
    */
    private $_catalogSession;

    /**
    * @var CustomerSession
    */
    private $_customerSession;

    /**
    * @var CheckoutSession
    */
    private $_checkoutSession;

    public function __construct(
        CatalogSession $catalogSession,
        CustomerSession $customerSession,
        CheckoutSession $checkoutSession,
    ) {
        $this->_checkoutSession = $checkoutSession;
        $this->_catalogSession = $catalogSession;
        $this->_customerSession = $customerSession;
    }

    public function getCatalogSession()
    {
        return $this->_catalogSession;
    }

    public function getCustomerSession()
    {
        return $this->_customerSession;
    }

    public function getCheckoutSession()
    {
        return $this->_checkoutSession;
    }
}