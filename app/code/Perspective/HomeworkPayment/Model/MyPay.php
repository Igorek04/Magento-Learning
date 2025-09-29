<?php

namespace Perspective\HomeworkPayment\Model;

use Perspective\HomeworkPayment\Helper\ConfigData;

class MyPay extends \Magento\Payment\Model\Method\AbstractMethod
{
    /**
     * Payment code
     *
     * @var string
     */
    protected $_code = 'mypay';

    /**
     * @var ConfigData
     */
    protected $configHelper;

    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Api\ExtensionAttributesFactory $extensionFactory,
        \Magento\Framework\Api\AttributeValueFactory $customAttributeFactory,
        \Magento\Payment\Helper\Data $paymentData,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Payment\Model\Method\Logger $logger,
        ConfigData $configHelper,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        parent::__construct(
            $context,
            $registry,
            $extensionFactory,
            $customAttributeFactory,
            $paymentData,
            $scopeConfig,
            $logger,
            $resource,
            $resourceCollection,
            $data
        );
        $this->configHelper = $configHelper;
    }

    public function authorize( \Magento\Payment\Model\InfoInterface $payment, $amount ) 
    {
        return $this;
    }

    /**
     * @param \Magento\Quote\Api\Data\CartInterface|\Magento\Quote\Model\Quote|null $quote
     * @return bool
     */
    public function isAvailable(\Magento\Quote\Api\Data\CartInterface $quote = null)
    {
        /** @var \Magento\Quote\Model\Quote $quote */
        if (!$this->isActive($quote ? $quote->getStoreId() : null)) {
            return false;
        }

        // Shipping method validation
        $shippingMethod = $quote->getShippingAddress()->getShippingMethod(); //method from order
        $carrierCode = explode('_', $shippingMethod)[0]; //example: from 'flatrate_flatrate' get 'flatrate'
        $allowedShipping = $this->configHelper->getAllowedShipping(); // method from config

        if ($allowedShipping !== 'all' && $carrierCode !== $allowedShipping) {
            return false;
        }

        // Categories validation
        $allowedCategories = $this->configHelper->getAllowedCategories();
        //if categories in config not selected -> all categories allowed
        if (!empty($allowedCategories)) {
            $quoteItems = $quote->getAllItems();

            foreach ($quoteItems as $item) {
                $productCategories = array_map('intval', $item->getProduct()->getCategoryIds());
                // check if product have any allowed category
                $intersection = array_intersect($allowedCategories, $productCategories);
                if (empty($intersection)) {
                    return false; 
                }
            }
        }
        return true;
    }
}