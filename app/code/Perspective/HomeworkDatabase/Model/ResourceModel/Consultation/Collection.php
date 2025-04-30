<?php

namespace Perspective\HomeworkDatabase\Model\ResourceModel\Consultation;

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
        $this->_init('Perspective\HomeworkDatabase\Model\Consultation',
                     'Perspective\HomeworkDatabase\Model\ResourceModel\Consultation');
    }
}