<?php
namespace Perspective\HolidayDiscounts\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HolidayDiscounts\Helper\Data as DataHelper;
use Perspective\HolidayDiscounts\Helper\Validation as ValidationHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class HolidayPriceDisplay implements ArgumentInterface
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
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param DataHelper $dataHelper
     * @param ValidationHelper $validationHelper
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        DataHelper $dataHelper,
        ValidationHelper $validationHelper,
        PriceCurrencyInterface $priceCurrency,
        ) {
        $this->dataHelper = $dataHelper;
        $this->validationHelper = $validationHelper;
        $this->priceCurrency = $priceCurrency;
    }

    public function getCurrentProduct()
    {
        return $this->dataHelper->getCurrentProduct();
    }

    public function getCurrentHoliday()
    {
        return $this->dataHelper->getCurrentHoliday();
    }

    public function isActiveHolidayProduct($product)
    {
        return $this->validationHelper->isActiveHolidayProduct($product);
    }

    /**
     * Check if holiday alert should show.
     *
     * @return bool
     */
    public function isHolidayAlertShow()
    {
        return $this->validationHelper->isCurrentHolidayEnabled()
            && $this->validationHelper->isModuleEnabled();
    }

    /**
     * Return current store currency symbol.
     *
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->priceCurrency->getCurrency()->getCurrencySymbol();
    }
}
