<?php

namespace Perspective\UiExample\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blog extends AbstractDb
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    public function _construct() 
    {
        $this->_init('perspective_blog', 'blog_id');
    }
}