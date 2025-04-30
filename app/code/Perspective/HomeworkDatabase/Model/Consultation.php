<?php

namespace Perspective\HomeworkDatabase\Model;

use Magento\Framework\Model\AbstractModel;

class Consultation extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('Perspective\HomeworkDatabase\Model\ResourceModel\Consultation');
    }
}