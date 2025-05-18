<?php

namespace Webkul\BlogManager\Model\ResourceModel\Blog\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use Magento\Framework\Api\Search\AggregationInterface;
use Magento\Framework\Search\Response\Aggregation;
use Webkul\BlogManager\Model\ResourceModel\Blog\Collection as BlogCollection;
use Magento\Framework\Data\Collection\EntityFactoryInterface;
use Psr\Log\LoggerInterface;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface;
use Magento\Framework\Event\ManagerInterface;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Collection extends BlogCollection implements SearchResultInterface
{
    protected $aggregations;

    public function __construct(
        EntityFactoryInterface $entityFactory,
        LoggerInterface $logger,
        FetchStrategyInterface $fetchStrategy,
        ManagerInterface $eventManager,
        $mainTable,
        $resourceModel,
        $model =
        \Magento\Framework\View\Element\UiComponent\DataProvider\Document::class,
        \Magento\Framework\DB\Adapter\AdapterInterface $connection =
        null,
        AbstractDb $resource = null
    ) {
        parent::__construct(
            $entityFactory,
            $logger,
            $fetchStrategy,
            $eventManager,
            $connection,
            $resource
        );
        $this->_init($model, $resourceModel);
        $this->setMainTable($mainTable);
        $this->aggregations = new Aggregation([]);
    }



    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }

    public function getSearchCriteria()
    {
        return null;
    }

    public function setSearchCriteria(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
        = null
    ) {
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

    protected function _renderFiltersBefore()
    {
        $cgfTable = $this->getTable('customer_grid_flat');
        
        $this->getSelect()->joinLeft(
            $cgfTable . ' as cgf',
            'main_table.user_id = cgf.entity_id',
            []
        )
            ->columns('IFNULL(cgf.name, "Admin") AS user_name');
        parent::_renderFiltersBefore();
    }

    protected function _initSelect()
    {
        $this->addFilterToMap('user_name', 'cgf.name');
        parent::_initSelect();
    }
}
