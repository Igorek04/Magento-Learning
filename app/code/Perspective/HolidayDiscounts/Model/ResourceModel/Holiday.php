<?php

namespace Perspective\HolidayDiscounts\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Holiday extends AbstractDb
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    public function _construct() 
    {
        $this->_init('perspective_holidays', 'holiday_id');
    }
}