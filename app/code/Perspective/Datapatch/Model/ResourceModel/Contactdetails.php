<?php

namespace Perspective\Datapatch\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Contactdetails extends AbstractDb
{
    public function _construct()
    {
        $this->_init("customer_contactdetails", 'id');
    }
}
?>