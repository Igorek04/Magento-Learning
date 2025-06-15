<?php

namespace Perspective\LastOrdersTab\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\LastOrdersTab\Model\ResourceModel\LastOrder as LastOrderResourceModel;

class LastOrder extends AbstractModel
{
    /**
     * Initialize model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(LastOrderResourceModel::class);
    }
}
