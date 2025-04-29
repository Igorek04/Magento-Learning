<?php

namespace Perspective\BDScriptPractice\Model;

use Magento\Framework\Model\AbstractModel;

class Post extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Perspective\BDScriptPractice\Model\ResourceModel\Post');
    }
}