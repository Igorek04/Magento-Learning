<?php

namespace Webkul\BlogManager\Model\ResourceModel;

class Comment extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init("blogmanager_comment", "entity_id");
    }
}
