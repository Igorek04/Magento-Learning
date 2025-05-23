<?php
 
namespace Perspective\UiExample\Model\ResourceModel\Blog\Grid;
 
use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface; 
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\View\Element\UiComponent\DataProvider\Document as BlogModel;
use Perspective\UiExample\Model\ResourceModel\Blog\Collection as BlogCollection;

class Collection extends BlogCollection implements SearchResultInterface
{
 
    protected $aggregations;
 
    // @codingStandardsIgnoreStart
    public function __construct(
        EntityFactoryInterface $entityFactory,
        \Psr\Log\LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $eventPrefix,
        $eventObject,
        $resourceModel,
        $model = BlogModel::class,
        $connection = null,
        AbstractDb $resource = null
    ) {
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
        $this->_eventPrefix = $eventPrefix;
        $this->_eventObject = $eventObject;
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
    }
 
    // @codingStandardsIgnoreEnd
 
    public function getAggregations()
    {
        return $this->aggregations;
    }
 
    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
 
    public function getAllIds($limit = null, $offset = null)
    {
        return $this->getConnection()->fetchCol($this->_getAllIdsSelect($limit, $offset), $this->_bindParams);
    }
 
    public function getSearchCriteria()
    {
        return null;
    }
 
    public function setSearchCriteria(SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
 
    public function getTotalCount()
    {
        return $this->getSize();
    }
 
    public function setTotalCount($totalCount)
    {
        return $this;
    }
 
    public function setItems(array $items = null)
    {
        return $this;
    }
}
