<?php
namespace Perspective\HomeworkWholesalers\Plugin;

use Perspective\HomeworkWholesalers\Helper\Data as DataHelper;
use Perspective\HomeworkWholesalers\Helper\Validation as ValidationHelper;

class ShippingFilter
{
    protected $groupType = null;
    protected $finalValidation = null;
    protected $allowedMethodId = null;

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
        ValidationHelper $validationHelper
    ) {
        $this->dataHelper = $dataHelper;
        $this->validationHelper = $validationHelper;
    }

    public function aroundCollectCarrierRates(
        \Magento\Shipping\Model\Shipping $subject,
        \Closure $proceed,
        $carrierCode,
        $request
    ) {
        //caching group type and validation
        if ($this->groupType === null) {
            $this->groupType = $this->dataHelper->getCurrentGroupType();
        }
        if ($this->finalValidation === null) {
            $this->finalValidation = $this->validationHelper->isCustomerGroupValid()
                                  && $this->validationHelper->isConditionValueValid($request);
        }

        //customer group and order condition validation
        if ($this->finalValidation) {
            if ($this->groupType === 'standart') {
                //caching required shipping method for standart wholesaler
                if ($this->allowedMethodId === null) {
                    $this->allowedMethodId = $this->dataHelper->getConfigMethodId($this->groupType, 'shipping');
                }

                //disable all methods exclude required method
                if ($carrierCode !== $this->allowedMethodId) {
                    return false;
                }
                
            } elseif ($this->groupType === 'large') {
                // disable all methods exclude freeshipping for large wholesaler
                if ($carrierCode !== 'freeshipping') {
                    return false;
                }
            }
        } else {
            if ($this->groupType === 'standart') {
                //if validation failed -> disable freeshipping for standart wholesaler 
                if ($carrierCode === 'freeshipping') {
                    return false;
                }
            }
        }
        return $proceed($carrierCode, $request);
    }
}
