<?php

namespace Perspective\LastOrdersTab\Model\ResourceModel\LastOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\LastOrdersTab\Model\ResourceModel\LastOrder as LastOrderResourceModel;
use Perspective\LastOrdersTab\Model\LastOrder as LastOrderModel;

class Collection extends AbstractCollection
{
    /**
    * Initialize resource collection
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init(LastOrderModel::class, LastOrderResourceModel::class);
    }
}