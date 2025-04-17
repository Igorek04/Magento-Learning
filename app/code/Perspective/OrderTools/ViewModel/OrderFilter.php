<?php

namespace Perspective\OrderTools\ViewModel;

use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class OrderFilter
 * @package Perspective\OrderTools\ViewModel
 */
class OrderFilter implements ArgumentInterface
{
    /**
     * @var OrderRepositoryInterface
     */
    private $orderRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * OrderFilter constructor.
     * 
     * @param OrderRepositoryInterface $orderRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     */
    public function __construct(
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->orderRepository = $orderRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    /**
     * Get orders filtered by grand total(Total price)
     * 
     * @param float $minPrice
     * @return OrderInterface[]
     */
    public function getFilteredOrders(float $minPrice): array
    {
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('grand_total', $minPrice, 'gteq')
            ->create();

        $result = $this->orderRepository->getList($searchCriteria);

        return $result->getItems();
    }
}
