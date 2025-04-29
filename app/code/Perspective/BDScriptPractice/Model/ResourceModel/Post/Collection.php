<?php

namespace Perspective\BDScriptPractice\Model\ResourceModel\Post;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
    * Define resource model
    *
    * @return void
    */
    protected function _construct()
    {
        $this->_init('Perspective\BDScriptPractice\Model\Post',
                     'Perspective\BDScriptPractice\Model\ResourceModel\Post');
    }
}