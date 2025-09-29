<?php

namespace Perspective\SimplePaymentMethod\Model;

class PaymentMethod extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'simplepayment';

    /**
     * Authorizes specified amount.
     *
     * @param InfoInterface $payment
     * @param float         $amount
     *
     * @return $this
     *
     * @throws LocalizedException
     */
    public function authorize( \Magento\Payment\Model\InfoInterface $payment, $amount ) 
    {
        return $this;
    }
}