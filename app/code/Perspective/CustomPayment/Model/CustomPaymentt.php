<?php
namespace Perspective\CustomPayment\Model;

use Magento\Quote\Api\Data\PaymentInterface;

class CustomPaymentt extends \Magento\Payment\Model\Method\AbstractMethod
{
    const PAYMENT_METHOD_PDQPAYMENT_CODE = 'custompayment';

    /**
     * Payment method code
     *
     * @var string
     */
    protected $_code = self::PAYMENT_METHOD_PDQPAYMENT_CODE;

    /**
     * @var string
     */
    protected $_formBlockType = \Perspective\CustomPayment\Block\Form\CustomPaymentt::class;

    /**
     * @var string
     */
    protected $_infoBlockType = \Perspective\CustomPayment\Block\Info\CustomPaymentt::class;

    /**
     * Availability option
     *
     * @var bool
     */
    protected $_isOffline = true;
}