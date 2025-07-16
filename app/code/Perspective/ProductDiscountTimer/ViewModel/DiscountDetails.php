<?php
namespace Perspective\ProductDiscountTimer\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\ProductDiscountTimer\Helper\Data as DataHelper;
use Magento\Framework\Pricing\PriceCurrencyInterface;

class DiscountDetails implements ArgumentInterface
{
    /**
     * @var DataHelper 
     */
    protected $dataHelper;

    /**
     * @var PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @param DataHelper $dataHelper
     * @param PriceCurrencyInterface $priceCurrency
     */
    public function __construct(
        DataHelper $dataHelper,
        PriceCurrencyInterface $priceCurrency,
        ) {
        $this->dataHelper = $dataHelper;
        $this->priceCurrency = $priceCurrency;
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

    public function getSpecialPriceData()
    {
        return $this->dataHelper->getSpecialPriceData();
    }

    public function getUnifiedDiscountRules()
    {
        return $this->dataHelper->getUnifiedDiscountRules();
    }

    public function isCatalogRuleCheaperThanSpecial()
    {
        return $this->dataHelper->isCatalogRuleCheaperThanSpecial();
    }
}
