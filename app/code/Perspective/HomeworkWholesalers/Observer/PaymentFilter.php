<?php
namespace Perspective\HomeworkWholesalers\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Perspective\HomeworkWholesalers\Helper\Data as DataHelper;
use Perspective\HomeworkWholesalers\Helper\Validation as ValidationHelper;

class PaymentFilter implements ObserverInterface 
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

    public function execute(Observer $observer) 
    {
        $quote = $observer->getEvent()->getQuote();
        //to exclude unnecessary checks, because this method is called earlier without quote
        if ($quote !== null) {
            
            //caching group type and validation
            if ($this->groupType === null) {
                $this->groupType = $this->dataHelper->getCurrentGroupType();
            }
            if ($this->finalValidation === null) {
                $this->finalValidation = $this->validationHelper->isCustomerGroupValid()
                                    && $this->validationHelper->isConditionValueValid($quote);
            }
            
            //customer group and order condition validation
            if ($this->finalValidation) {
                //caching required payment method
                if ($this->allowedMethodId === null) {
                    $this->allowedMethodId = $this->dataHelper->getConfigMethodId($this->groupType, 'payment');
                }
                //get current payment method
                $paymentMethodId = $observer->getEvent()->getMethodInstance()->getCode();

                //disable all methods exclude required
                if ($paymentMethodId !== $this->allowedMethodId) {
                    $result = $observer->getEvent()->getResult();
                    $result->setData('is_available', false);
                }
            }
        }
    }
}