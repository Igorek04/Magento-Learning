<?php

namespace Webkul\BlogManager\Model\ResourceModel\Comment;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    public function _construct()
    {
        $this->_init(
            \Webkul\BlogManager\Model\Comment::class,
            \Webkul\BlogManager\Model\ResourceModel\Comment::class
        );
        $this->_map['fields']['entity_id'] = 'main_table.entity_id';
    }
}
