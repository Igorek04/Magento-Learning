<?php
namespace Perspective\HomeworkWholesalers\Helper;

use Perspective\HomeworkWholesalers\Helper\Data as DataHelper;

class Validation extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var DataHelper
     */
    protected $dataHelper;

    /**
     * @param DataHelper $dataHelper
     */
    public function __construct(DataHelper $dataHelper) 
    {
        $this->dataHelper = $dataHelper;
    }

    /**
     * Check if customer group valid(standart or large)
     *
     * @return bool
     */
    public function isCustomerGroupValid()
    {
        if ($this->dataHelper->getCurrentGroupType() === 'another') {
            return false;
        };
        return true;
    }

    /**
     * Check if condition completed for current order (current qty/price > config qty/price)
     *
     * @param \Magento\Quote\Model\Quote\Address\RateRequest|\Magento\Quote\Model\Quote $source
     *
     * @return bool
     */
    public function isConditionValueValid($source)
    {
        $customerGroupType = $this->dataHelper->getCurrentGroupType();
        $configConditionValue = $this->dataHelper->getConfigConditionValue($customerGroupType);
        $orderConditionValue = $this->dataHelper->getOrderConditionValue($customerGroupType, $source);

        if ($orderConditionValue > $configConditionValue) {
            return true;
        }
        return false;
    }
}