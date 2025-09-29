<?php
namespace Perspective\CustomPayment\Block\Info;

class CustomPaymentt extends \Magento\Payment\Block\Info
{
    /**
     * @var string
     */
    protected $_template = 'Perspective_CustomPayment::info/custompayment.phtml';

    /**
     * @return string
     */
    public function toPdf()
    {
        $this->setTemplate('Perspective_CustomPayment::info/pdf/custompayment.phtml');
        return $this->toHtml();
    }
}