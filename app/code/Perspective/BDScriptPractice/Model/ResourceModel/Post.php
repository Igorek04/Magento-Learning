<?php

namespace Perspective\BDScriptPractice\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Post extends AbstractDb
{
    public function _construct() 
    {
        $this->_init('perspective_bdscriptpractice_post', 'post_id');
    }
}