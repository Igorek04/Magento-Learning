<?php
namespace Perspective\TutorialEntity\ViewModel;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class EntityZavd3 implements ArgumentInterface
{
    private $customerRepository;
    private $searchCriteriaBuilder;

    public function __construct(
        CustomerRepositoryInterface $customerRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->customerRepository = $customerRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getAllCustomers()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $result = $this->customerRepository->getList($searchCriteria);
        return $result->getItems();
    }
}