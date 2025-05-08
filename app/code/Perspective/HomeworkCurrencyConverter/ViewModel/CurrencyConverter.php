<?php

namespace Perspective\HomeworkCurrencyConverter\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HomeworkCurrencyConverter\Helper\CustomData;
use Perspective\HomeworkCurrencyConverter\Helper\MagentoData;
use Magento\Catalog\Helper\Data as CatalogHelper;

class CurrencyConverter implements ArgumentInterface
{
    /**
     * @var CustomData
     */
    private CustomData $customDataHelper;

    /**
     * @var MagentoData
     */
    private MagentoData $magentoDataHelper;

    /**
     * @var CatalogHelper
     */
    private CatalogHelper $catalogHelper;

    /**
     * Constructor
     *
     * @param CustomData $customDataHelper
     * @param MagentoData $magentoDataHelper
     * @param CatalogHelper $catalogHelper
     */
    public function __construct(
        CustomData $customDataHelper,
        MagentoData $magentoDataHelper,
        CatalogHelper $catalogHelper
    ) {
        $this->customDataHelper = $customDataHelper;
        $this->magentoDataHelper = $magentoDataHelper;
        $this->catalogHelper = $catalogHelper;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->customDataHelper->isModuleEnabled();
    }

    /**
     * @return bool
     */
    public function isUAHConverterEnabled()
    {
        return $this->customDataHelper->isUAHConverterEnabled();
    }

    /**
     * @return bool
     */
    public function isRUBConverterEnabled()
    {
        return $this->customDataHelper->isRUBConverterEnabled();
    }

    /**
     * @return bool
     */
    public function isEUROConverterEnabled()
    {
        return $this->customDataHelper->isEUROConverterEnabled();
    }
    
    /**
     * @return string
     */
    public function getCustomCourseUAH()
    {
        return $this->customDataHelper->getCustomCourseUAH();
    }

    /**
     * @return string
     */
    public function getCustomCourseRUB()
    {
        return $this->customDataHelper->getCustomCourseRUB();
    }

    /**
     * @return string
     */
    public function getCustomCourseEURO()
    {
        return $this->customDataHelper->getCustomCourseEURO();
    }

    /**
     * @param string $currencyCode
     * 
     * @return string
     */
    public function getMagentoCourse($currencyCode)
    {
        return $this->magentoDataHelper->getMagentoCourse($currencyCode);
    }

    /**
     * @return string
     */
    public function getProductPrice()
    {
        return $this->catalogHelper->getProduct()->getPrice();
    }

    /**
     * @param string $currencyCode
     * 
     * @return string
     */
    public function getCurrencySymbol($currencyCode)
    {
        return $this->magentoDataHelper->getCurrencySymbol($currencyCode);
    }

}
