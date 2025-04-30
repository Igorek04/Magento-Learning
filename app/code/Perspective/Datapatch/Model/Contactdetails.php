<?php

namespace Perspective\Datapatch\Model;

use Magento\Framework\Model\AbstractModel;

class Contactdetails extends AbstractModel
{
    protected function _construct()
    {
        $this->_init("Perspective\Datapatch\Model\ResourceModel\Contactdetails");
    }
}
?>