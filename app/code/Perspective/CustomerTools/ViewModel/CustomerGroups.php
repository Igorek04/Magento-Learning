<?php
namespace Perspective\CustomerTools\ViewModel;

use Magento\Customer\Api\GroupRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CustomerGroups implements ArgumentInterface
{
    /**
     * @var GroupRepositoryInterface
     */
    private GroupRepositoryInterface $groupRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private SearchCriteriaBuilder $searchCriteriaBuilder;

    public function __construct(
        GroupRepositoryInterface $groupRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->groupRepository = $groupRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get all customer groups
     *
     * @return \Magento\Customer\Api\Data\GroupInterface[]
     */
    public function getCustomerGroups(): array
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $result = $this->groupRepository->getList($searchCriteria);
        
        return $result->getItems();
    }
}
