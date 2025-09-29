<?php
namespace Perspective\DisablePaymentMethod\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class PaymentMethodDisable implements ObserverInterface 
{
    protected $_customerSession;

    public function __construct(
       \Magento\Customer\Model\Session $customerSession
    ) {
       $this->_customerSession = $customerSession;
    }

    public function execute(Observer $observer) 
    {
        $method = $observer->getEvent()->getMethodInstance();
        $payment_method_code = $method->getCode();
        if ($payment_method_code === 'simplepayment') {
            $result = $observer->getEvent()->getResult();
            if (!$this->_customerSession->isLoggedIn()) {
                    $result->setData('is_available', false);
            }
       }
    }
}