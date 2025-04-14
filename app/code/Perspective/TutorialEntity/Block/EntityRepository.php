<?php
namespace Perspective\TutorialEntity\Block;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class EntityRepository extends Template
{
    /**
     * @var ProductRepositoryInterface
     */
    private $_productRepository;

    /**
     * @var SearchCriteriaBuilder
     */
    private $_searchCriteriaBuilder;

    /**
     * Конструктор
     *
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param array $data
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        array $data = []
    ) {
        $this->_productRepository = $productRepository;
        $this->_searchCriteriaBuilder = $searchCriteriaBuilder;
        parent::__construct($context, $data);
    }

    /**
     * Получить продукт по ID
     *
     * @param int $productId
     * @return \Magento\Catalog\Api\Data\ProductInterface|null
     */
    public function getProductById($productId)
    {
        if (is_null($productId)) {
            return null;
        }

        return $this->_productRepository->getById($productId);
    }

    /**
     * Получить продукты дешевле указанной цены
     *
     * @param float $price
     * @return \Magento\Catalog\Api\Data\ProductInterface[]|null
     */
    public function getCheapProducts($price)
    {
        if (is_null($price)) {
            return null;
        }

        $this->_searchCriteriaBuilder->addFilter(
            ProductInterface::PRICE,
            $price,
            'lt' // "lt" — less than (меньше)
        );

        $searchCriteria = $this->_searchCriteriaBuilder->create();
        $productCollection = $this->_productRepository->getList($searchCriteria);

        return $productCollection->getItems();
    }
}
