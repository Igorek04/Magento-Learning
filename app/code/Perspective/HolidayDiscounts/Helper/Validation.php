<?php
namespace Perspective\HolidayDiscounts\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session;
use Perspective\HolidayDiscounts\Helper\Data as DataHelper;

class Validation extends AbstractHelper
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var DataHelper 
     */
    protected $dataHelper;

    protected $isModuleEnabled = null;
    protected $isCustomerGroupAllowed = null;
    protected $isCurrentHolidayEnabled = null;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param Session $customerSession
     * @param DataHelper $dataHelper
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        Session $customerSession,
        DataHelper $dataHelper,
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Check if holiday discount module is enabled in config.
     *
     * @param string $scope
     * 
     * @return bool
     */
    public function isModuleEnabled($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if ($this->isModuleEnabled === null) {
            $this->isModuleEnabled = $this->scopeConfig->isSetFlag(
                'holiday_discounts/settings/enabled',
                $scope
            );
        }
        return $this->isModuleEnabled;
    }

    /**
     * Check if "is_holiday" attribute is enabled for product.
     *
     * @param \Magento\Catalog\Model\Product $product
     * 
     * @return bool|int|null
     */
    public function isHolidayAttributeEnabled(\Magento\Catalog\Model\Product $product)
    {
        return $product->getData('is_holiday');
    }

    /**
     * Check if current customer group is allowed for holiday discount.
     *
     * @param string $scope
     * 
     * @return bool
     */
    public function isCustomerGroupAllowed($scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT)
    {
        if ($this->isCustomerGroupAllowed !== null) {
            return $this->isCustomerGroupAllowed;
        }

        $allowedGroupIds = $this->scopeConfig->getValue(
            'holiday_discounts/settings/customer_groups',
            $scope
        );
        $customerGroupId = $this->customerSession->getCustomerGroupId();

        $this->isCustomerGroupAllowed = in_array($customerGroupId, explode(',', $allowedGroupIds));
        return $this->isCustomerGroupAllowed;
    }

    /**
     * Check if current active holiday is enabled.
     *
     * @return bool
     */
    public function isCurrentHolidayEnabled()
    {
        if ($this->isCurrentHolidayEnabled !== null) {
            return $this->isCurrentHolidayEnabled;
        }

        $holiday = $this->dataHelper->getCurrentHoliday();
        if (!$holiday) {
            $this->isCurrentHolidayEnabled = false;
            return false;
        }

        if ($holiday->getStatus()) {
            $this->isCurrentHolidayEnabled = true;
            return true;
        }

        $this->isCurrentHolidayEnabled = false;
        return false;
    }
    
    /**
     * Check if holiday discount can be applied for product and current customer.
     *
     * @param \Magento\Catalog\Model\Product $product
     * 
     * @return bool
     */
    public function isActiveHolidayProduct(\Magento\Catalog\Model\Product $product)
    {
        return $this->isModuleEnabled()
            && $this->isCurrentHolidayEnabled()
            && $this->isCustomerGroupAllowed()
            && $this->isHolidayAttributeEnabled($product);
    }
}