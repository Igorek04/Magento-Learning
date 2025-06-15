<?php

namespace Perspective\LastOrdersTab\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class LastOrder extends AbstractDb
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    public function _construct() 
    {
        $this->_init('perspective_last_product_orders', 'id');
    }
}