<?php
namespace Perspective\HomeworkWholesalers\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * @var Session
     */
    protected $customerSession;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    protected $searchCriteriaBuilder;

    /**
     * @param Session $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param GroupRepositoryInterface $groupRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        Session $customerSession,
        ScopeConfigInterface $scopeConfig,
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customerSession = $customerSession;
        $this->scopeConfig = $scopeConfig;
        $this->groupRepository = $groupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get current customer group id from session
     * 
     * @return int
     */
    public function getCustomerGroupId()
    {
        return $this->customerSession->getCustomerGroupId();
    }

    /**
     * Find group id by group code
     * 
     * @param string $groupCode
     *
     * @return int
     */
    public function getGroupIdByCode(string $groupCode)
    {
        // filter by code
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('customer_group_code', $groupCode)
            ->create();

        // get group id from repository by filter with code
        $groups = $this->groupRepository->getList($searchCriteria)->getItems();
        $group = reset($groups);
        if (!empty($group)) {
            return $group->getId();
        }
        return null;
    }

    /**
     * Get allowed group id from config
     * 
     * @param string $groupType  (standart / large)
     *
     * @return int
     */
    public function getAllowedGroupId(string $groupType)
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $path = 'wholesalers/' . $groupType . '_wholesaler/group';

        $allowedGroupId = $this->scopeConfig->getValue(
            $path,
            $scope
        );

        //if group in config not selected -> use created groups 'homework_$groupType_wholesaler'
        if ($allowedGroupId === null) {
            $allowedGroupId = $this->getGroupIdByCode('homework_' . $groupType . '_wholesaler');
        }
        return $allowedGroupId;
    }

    /**
     * Get current user group type 
     * 
     * @return string (standart / large / another)
     */
    public function getCurrentGroupType()
    {
        $customerGroupId = $this->getCustomerGroupId();
        if ($customerGroupId === $this->getAllowedGroupId('standart')) {
            return 'standart';
        } elseif ($customerGroupId === $this->getAllowedGroupId('large')) {
            return 'large';
        }
        return 'another';
    }

    /**
     * Get condition value (qty / price) from config by group type
     * 
     * @param string $groupType (standart / large)
     *
     * @return int|float
     */
    public function getConfigConditionValue(string $groupType)
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $path = 'wholesalers/' . $groupType . '_wholesaler/condition';

        return $this->scopeConfig->getValue(
            $path,
            $scope
        );
    }

    /**
     * Get current order qty or subtotal by group type and source
     * 
     * @param string $groupType (standart / large)
     * @param \Magento\Quote\Model\Quote\Address\RateRequest|\Magento\Quote\Model\Quote $source
     *
     * @return int|float
     */
    public function getOrderConditionValue(string $groupType, $source)
    {
        if ($groupType === 'standart') {
            $qty = $source->getPackageQty(); //for request in shipping plugin
            if ($qty === null) {
                $qty = $source->getItemsQty(); //for quote in payment observer
            }
            return $qty;
        }

        if ($groupType === 'large') {
            $price = $source->getPackageValue();
            if ($price === null) {
                $price = $source->getSubtotal();
            }
            return $price;
        }
        return 0;
    }

    /**
     * Get method id from config
     *
     * @param string $groupType (standart / large)
     * @param string $methodType (shipping / payment)
     *
     * @return int
     */
    public function getConfigMethodId(string $groupType, string $methodType)
    {
        $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
        $path = 'wholesalers/' . $groupType . '_wholesaler/' . $methodType . '_method';

        return $this->scopeConfig->getValue(
            $path,
            $scope
        );
    }
}