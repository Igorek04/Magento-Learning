<?php

namespace Perspective\UiExample\Model\ResourceModel\Blog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Perspective\UiExample\Model\ResourceModel\Blog as BlogResourceModel;
use Perspective\UiExample\Model\Blog as BlogModel;

class Collection extends AbstractCollection
{
    /**
    * Initialize resource collection
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init(BlogModel::class, BlogResourceModel::class);
    }
}