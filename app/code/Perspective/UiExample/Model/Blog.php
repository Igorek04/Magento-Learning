<?php

namespace Perspective\UiExample\Model;

use Magento\Framework\Model\AbstractModel;
use Perspective\UiExample\Model\ResourceModel\Blog as BlogResourceModel;

class Blog extends AbstractModel
{
    /**
     * Initialize model
     * 
     * @return void
     */
    protected function _construct()
    {
        $this->_init(BlogResourceModel::class);
    }
}
