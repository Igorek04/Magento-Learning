<?php

namespace Perspective\HolidayDiscounts\Observer;

use Perspective\HolidayDiscounts\Helper\Validation as ValidationHelper;
use Perspective\HolidayDiscounts\Helper\Data as DataHelper;

class HolidayPriceModifier implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var DataHelper 
     */
    protected $dataHelper;

    /**
     * @var ValidationHelper 
     */
    protected $validationHelper;

    /**
     * @param DataHelper $dataHelper
     * @param ValidationHelper $validationHelper
     */
    public function __construct(
        DataHelper $dataHelper,
        ValidationHelper $validationHelper,
        ) {
        $this->dataHelper = $dataHelper;
        $this->validationHelper = $validationHelper;
    }

    /**
     * Apply holiday discount to product final price.
     *
     * @param \Magento\Framework\Event\Observer $observer
     * 
     * @return void
     */
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $product = $observer->getEvent()->getProduct();

        if ($this->validationHelper->isActiveHolidayProduct($product)) {
            $finalPrice = $product->getData('final_price');
            $discount = $this->dataHelper->getCurrentHoliday()['discount_rate'];

            $product->setFinalPrice($finalPrice * (1-($discount/100)));
        }
    }
}