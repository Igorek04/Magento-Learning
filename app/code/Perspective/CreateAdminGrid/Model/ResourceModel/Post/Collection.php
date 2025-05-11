<?php

namespace Perspective\CreateAdminGrid\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'post_id';

    protected $_eventPrefix = 'perspective_createadmingrid_post_collection';

    protected $_eventObject = 'post_collection';

    /**
    * Define resource model
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init('Perspective\CreateAdminGrid\Model\Post',
                     'Perspective\CreateAdminGrid\Model\ResourceModel\Post');
    }
}