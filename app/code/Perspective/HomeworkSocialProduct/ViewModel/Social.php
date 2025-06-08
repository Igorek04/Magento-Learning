<?php
namespace Perspective\HomeworkSocialProduct\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Perspective\HomeworkSocialProduct\Helper\Social as SocialHelper;

class Social implements ArgumentInterface
{
    /**
     * @var SocialHelper
     */
    protected $socialHelper;

    /**
     * @param SocialHelper $socialHelper
     */
    public function __construct(
        SocialHelper $socialHelper
    ) {
        $this->socialHelper = $socialHelper;
    }

    /**
     * @return bool
     */
    public function isModuleEnabled()
    {
        return $this->socialHelper->isModuleEnabled();
    }

    /**
     * @return string
     */
    public function getSocialDiscountRate()
    {
        return $this->socialHelper->getSocialDiscountRate();
    }
    
    /**
     * @return \Magento\Catalog\Model\Product
     */
    public function getCurrentProduct()
    {
        return $this->socialHelper->getCurrentProduct();
    }

    /**
     * @return bool
     */
    public function isSocialAttributeEnabled()
    {
        return $this->socialHelper->isSocialAttributeEnabled();
    }

    /**
     * @return string
     */
    public function getSocialPrice()
    {
        return $this->socialHelper->getSocialPrice();
    }

    /**
     * @return string
     */
    public function getCurrencySymbol()
    {
        return $this->socialHelper->getCurrencySymbol();
    }
}