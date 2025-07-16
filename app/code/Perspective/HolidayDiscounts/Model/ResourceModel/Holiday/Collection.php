<?php

namespace Perspective\HolidayDiscounts\Model\ResourceModel\Holiday;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\HolidayDiscounts\Model\ResourceModel\Holiday as HolidayResourceModel;
use Perspective\HolidayDiscounts\Model\Holiday as HolidayModel;

class Collection extends AbstractCollection
{
    /**
    * Initialize resource collection
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init(HolidayModel::class, HolidayResourceModel::class);
    }
}