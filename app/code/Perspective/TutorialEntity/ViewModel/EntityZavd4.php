<?php
namespace Perspective\TutorialEntity\ViewModel;

use Magento\Catalog\Api\CategoryListInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class EntityZavd4 implements ArgumentInterface
{
    private $categoryList;
    private $searchCriteriaBuilder;

    public function __construct(
        CategoryListInterface $categoryList,
        SearchCriteriaBuilder $searchCriteriaBuilder
    ) {
        $this->categoryList = $categoryList;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
    }

    public function getAllCategories()
    {
        $searchCriteria = $this->searchCriteriaBuilder->create();
        $result = $this->categoryList->getList($searchCriteria);
        return $result->getItems();
    }
}