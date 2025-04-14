<?php
namespace Perspective\TutorialEntity\ViewModel;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Api\SortOrderBuilder;

class EntityZavd2 implements ArgumentInterface
{
    private $productRepository;
    private $searchCriteriaBuilder;
    private $sortOrderBuilder;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->productRepository = $productRepository;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    public function getFilteredProducts(
        string $letter,
        float $minPrice,
        float $maxPrice,
        int $limit)
    {
        // Фільтр по імені (починається на букву)
        $this->searchCriteriaBuilder->addFilter(
            ProductInterface::NAME,
            $letter . '%',
            'like'
        );

        // Мінімальна ціна
        $this->searchCriteriaBuilder->addFilter(
            ProductInterface::PRICE,
            $minPrice,
            'gteq'
        );

        // Максимальна ціна
        $this->searchCriteriaBuilder->addFilter(
            ProductInterface::PRICE,
            $maxPrice,
            'lteq'
        );

        // Сортування по ціні за спаданням
        $sortOrder = $this->sortOrderBuilder
            ->setField(ProductInterface::PRICE)
            ->setDirection('DESC')
            ->create();

        $searchCriteria = $this->searchCriteriaBuilder
            ->addSortOrder($sortOrder)
            ->setPageSize($limit)
            ->create();

        $result = $this->productRepository->getList($searchCriteria);
        return $result->getItems();
    }
}